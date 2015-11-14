<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Traits\SocialiteHelpers;
use App\Http\Requests\Request;
use App\Models\SocialLink;
use App\Models\SocialNetwork;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\User as UserReq;
use App\Models\User;
use LaravelArdent\Ardent\InvalidModelException;

class AuthController extends Controller {

    use AuthenticatesUsers, ThrottlesLogins, SocialiteHelpers {
        AuthenticatesUsers::getLogin as getLoginBasic;
    }
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

    /**
     * Get the needed authorization credentials from the request.
     * @param  \Illuminate\Http\Request $req
     * @return array
     */
    protected function getCredentials(\Illuminate\Http\Request $req) {
        return [
            'password' => $req->password,
            (str_contains($req->email, '@')? 'email' : 'username') => $req->email
        ];
    }

    protected function loginAfterSignUp(User $user) {
        Auth::login($user);
        return $this->handleUserWasAuthenticated(request(), $this->isUsingThrottlesLoginsTrait());
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
                return $this->loginAfterSignUp($link->user);
            }

            $user = new User();
            $user->name     = $data->getName();
            $user->email    = $data->getEmail();
            $user->avatar   = $data->getAvatar();
            $user->username = strtok($user->email, '@');
            if (isset($data->user)) {
                $this->fillUser($user, $data->user, $data, $provider);
            }

            //for some odd reason, Laravel is unable to automatically serialize the user object(?), so we do it by hand
            session()->set('signup.user', serialize($user));
            return view('auth.finishSignUp', compact('user', 'provider'));
        } catch (\Exception $e) {
            \Log::error(class_basename($e).' during social auth ('.printr($_GET).'): ['.$e->getCode().'] '.$e->getMessage());
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
                $user = unserialize(session('signup.user'));
                $user->username = $req->username;
                $user->throwOnValidation = true; //todo: https://github.com/laravel-ardent/ardent/issues/279
                $user->save();

                $relations = session('signup.relations');
                foreach ($relations as $relation => $data) {
                    switch ($relation) {
                        case 'links':
                            foreach ($data as $provider => $username) {
                                $link = new SocialLink();
                                $link->network()->associate(SocialNetwork::find($provider));
                                $link->user()->associate($user);
                                $link->username = $username;
                                $link->throwOnValidation = true;
                                $link->save();
                            }
                            break;

                        default:
                            \Log::emergency("Not yet implemented Sign Up relation called $relation: ".printr($data));
                    }
                }

                //those fields should not be "pulled" as an error might rise and their values can be reused in a 2nd try
                session()->remove('signup.user');
                session()->remove('signup.relations');
            });
        }
        catch (InvalidModelException $e) {
            return redirect()->action('AuthController@getSignUp')
                             ->with('social_error', true)
                             ->with('provider', $req->provider)
                             ->withErrors($e->getErrors());
        }
        catch (\Exception $e) {
            throw $e;
            \Log::error(class_basename($e).' during social auth ('.printr($_GET).'): ['.$e->getCode().'] '.$e->getMessage());
            return redirect()->action('AuthController@getSignUp')
                             ->with('social_error', true)
                             ->with('provider', $req->provider);
        }

        return redirect()->intended($this->redirectPath());
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
        $user = new User(\Input::except('_token'));
        $user->save();
        return $this->loginAfterSignUp($user);
    }

    public function getLogin() {
        if (!\Session::has('url.intended')) {
            \Session::put('url.intended', $_SERVER['HTTP_REFERER']?? '/');
        }

        return $this->getLoginBasic();
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
            'username' => User::$rules['username'],
            'provider' => 'required'
        ];
    }
}
