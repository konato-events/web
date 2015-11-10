<?php
namespace App\Http\Controllers;
use App\Http\Requests\Request;
use App\Models\SocialLink;
use App\Models\SocialNetwork;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User as UserContract;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\User as UserReq;
use App\Models\User;

class AuthController extends Controller {

    use AuthenticatesUsers, ThrottlesLogins, SocialiteHelpers;
//    use ResetsPasswords;

    protected $redirectPath = '/';

    /**
     * This is actually the default value. This property is where the user will be sent if auth fails - not where the
     * user will bounce if accessing a protected route, that's App\Http\Middleware\Authenticate::handle()'s problem.
     */
    protected $loginPath = '/auth/login';

    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /* *****************************  SOCIALITE ROUTES ***************************** */

    public function getProvider(string $provider) {
        return $this->driver($provider, isset($_GET['popup']))->redirect();
    }

    public function getCallback(string $provider) {
        try {
            $data = $this->driver($provider)->user();

            //if there's already a user with this social account, let's log him in!
            /** @var SocialLink $link */
            $link = SocialNetwork::find($provider)->links()
                ->where('username', $data->getId())
                ->with('user')
                ->first();

            if ($link) {
                \Auth::login($link->user);
                return $this->handleUserWasAuthenticated(request(), $this->isUsingThrottlesLoginsTrait());
            }

            $user = new User();
            $user->name     = $data->getName();
            $user->email    = $data->getEmail();
            $user->avatar   = $data->getAvatar();
            $user->username = strtok($user->email, '@');
            if (isset($data->user)) {
                $this->fillUser($user, $data->user, $data, $provider);
            }

            $provider_id = $data->getId();
            session(['user' => $user]);
            return view('auth.finishSignUp', compact('user', 'provider', 'provider_id'));
        } catch (\Exception $e) {
            $class = classname($e);
            \Log::error(classname($e).' during social auth ('.printr($_GET).'): ['.$e->getCode().'] '.$e->getMessage());
            return redirect()
                ->action('AuthController@getSignUp')
                ->with('social_error', true)
                ->with('provider', $provider);
        }
    }

    public function postFinishSignUp(FinishSignUpReq $req) {
        /** @var User $user */

        try {
            \DB::transaction(function() use ($req) {
                $network = SocialNetwork::find($req->provider);
                $link    = new SocialLink();
                $user    = session('user');

                $user->username = $req->username;
                $user->throwOnValidation = true; //todo: https://github.com/laravel-ardent/ardent/issues/279
                $user->save();

                $link->username = $req->provider_id;
                $link->network()->associate($network);
                $link->user()->associate($user);
                $link->throwOnValidation = true;
                $link->save();
            });
        }
        catch (\Exception $e) {
            \Log::error(classname($e).' during social auth ('.printr($_GET).'): ['.$e->getCode().'] '.$e->getMessage());
            return redirect()->action('AuthController@getSignUp')
                             ->with('social_error', true)
                             ->with('provider', $req->provider);
        }


        return redirect('/');
    }

    /** @todo going to receive a ping whenever a user deauthorizes in the provider - test with Facebook! */
    public function getDeauth(string $provider) {

    }

    /* ******************************  COMMON ROUTES ******************************* */

    public function getSignUp() {
        $user = new User;
        return view('auth.signUp', compact('user'));
    }

    public function postSignUp(UserReq $req) {
        $user = new User($_POST);
        !ddd($user);
    }
}

trait SocialiteHelpers {

    protected function driver(string $provider, bool $popup = false):Provider {
        $driver = Socialite::driver($provider);

        switch ($provider) {
            case 'facebook':
                /** @var \Laravel\Socialite\Two\FacebookProvider $driver */
                $driver
                    ->scopes(['public_profile', 'email', 'user_about_me', 'user_birthday', 'user_events', 'user_website', 'user_work_history', 'rsvp_event', 'user_location', 'user_education_history'])
                    ->fields(['first_name', 'last_name', 'gender', 'email', 'birthday', 'link', 'website', 'location', 'locale', 'timezone', 'bio', 'education', 'work']);
                break;
        }

        return $driver;
    }

    protected function fillUser(User $user, array $user_data, UserContract $data, string $provider) {
        $relations = [
            'birthday'         => 'birthday',
            'gender'           => 'gender',
            'rel:location'     => 'location.name',
            'rel:timezone'     => 'timezone',
            'rel:locale'       => 'locale',
            'rel:social_links' => 'website',
            "rel:$provider" => 'link',
            'tagline'          => 'work',
            'avatar'           => '',
            'picture'          => '',
        ];

        foreach ($relations as $field => $key) {
            if (strpos($field, 'rel:') === false) {
                if ($key) {
                    if (strpos($key, '.') === false) {
                        $value = $user_data[$key];
                    } else {
                        $value   = $user_data;
                        $sub_key = strtok($key, '.');
                        do {
                            $value = $value[$sub_key];
                        } while ($sub_key = strtok('.'));
                    }
                } else {
                    $value = null;
                }

                switch ($field) {
                    case 'birthday':
                        $value = \DateTime::createFromFormat('m/d/Y', $value)->format('Y-m-d');
                        break;

                    case 'tagline':
                        $last_job = current($value);
                        $value    = "{$last_job['position']['name']} @ {$last_job['employer']['name']}";
                        break;

                    case 'gender':  $value = strtoupper($value[0]); break;

                    case 'avatar':  $value = $data->getAvatar(); break;

                    case 'picture': $value = $data->avatar_original; break;
                }
                $user->$field = $value;
            } else {
                $relation = substr($field, 4);
                //TODO: implement relationships here
                switch ($relation) {
                    case 'social_links':
                        //TODO: add a "social network" link here as "website"
                        break;

                    case $provider: //Facebook's profile
                        //TODO: add a "social network" link here as $provider
                        break;

                    case 'location': //Facebook's profile
                        //TODO: add a location relationship here
                        break;

                    case 'locale': //Facebook's profile
                        //TODO: add a language relationship here
                        break;

                    case 'timezone': //Facebook's profile
                        //TODO DAFUK timezone comes as -2 USELESS HALP
                        //TODO: add a timezone relationship here
                        break;
                }
            }
        }
    }
}

/**
 * @property string username
 * @property string provider
 * @property string provider_id
 */
class FinishSignUpReq extends Request {
    function rules() {
        return [
            'username'    => User::$rules['username'],
            'provider'    => 'required',
            'provider_id' => 'required'
        ];
    }
}
