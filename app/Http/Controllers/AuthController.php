<?php namespace App\Http\Controllers;
use App\Http\Controllers\Traits\SocialiteHelpers;
use App\Http\Requests\SignUpFinish;
use App\Models\SocialLink;
use App\Models\SocialNetwork;
use App\Models\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request as BaseRequest;
use LaravelArdent\Ardent\InvalidModelException;
use Auth;
use Session;

class AuthController extends Controller {

    use AuthenticatesUsers, ThrottlesLogins, SocialiteHelpers {
        AuthenticatesUsers::getLogin as loginBasic;
    }
//    use ResetsPasswords;

    /**
     * This is actually the default value. This property is where the user will be sent if auth fails - not where the
     * user will bounce if accessing a protected route, that's App\Http\Middleware\Authenticate::handle()'s problem.
     */
    protected $loginPath = '/auth/login';

    public function __construct() {
        $this->middleware('auth', ['only' => 'getLogout']);
    }

    /**
     * Overwrites the intended URL if we notice the user would be sent to a "useless" page
     * @return string
     */
    public function redirectPath() {
        $intended = Session::remove('url.intended');
        $useless  = [null, '', ROOT_URL.'/', act('auth@login'), act('auth@signUp')];
        return in_array($intended, $useless)?
            act('user@profile', slugify(Auth::user()->id, Auth::user()->username)) :
            $intended?? $this->redirectTo?? '/home';
    }

    /**
     * Get the needed authorization credentials from the request.
     * @param  BaseRequest $req
     * @return array
     */
    protected function getCredentials(BaseRequest $req) {
        return [
            'password' => $req->password,
            (str_contains($req->email, '@')? 'email' : 'username') => $req->email
        ];
    }

    protected function loginAfterSignUp(User $user, string $provider = '') {
        if ($provider) {
            $path = act('auth@login');
            $path = substr($path, 0, strrpos($path, '/'));
            setcookie('last_login_provider', $provider, null, $path);
        }
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

            //if there's already an user with this social account, let's log him in!
            /** @var SocialLink $link */
            if ($link = SocialNetwork::find($provider)->links()
                    ->where('username', $data->getId())
                    ->with('user')
                    ->first()) {
                return $this->loginAfterSignUp($link->user, $provider);
            }

            //if there's already an user with this social email, let's merge accounts
            /** @var User $user */
            if (($user = \Auth::user()) ||
                ($data->getEmail() && $user = User::where('email', $data->getEmail())->first())
            ) {
                $this->fillUser($user, $data->user, $data, $provider);
                if (\DB::transaction(function() use ($user) {
                    //tries to save the user data from fillUser + the main network. If it fails, throw up
                    $user->throwOnValidation = true;
                    $user->save();
                    $this->saveLinks($user, true);
                    return true;
                })) {
                    //if it works, let's go ahead, save other links (that might fail in case they're dups) and finish
                    $this->saveLinks($user);
                    return $this->loginAfterSignUp($user, $provider);
                }
            }

            $user = new User();
            $this->fillUser($user, $data->user, $data, $provider);
            $user->username = $user->username?? $data->getNickname()?? strtok($user->email, '@');
            $user->picture  = $user->picture?? $user->avatar;

            //for some odd reason, Laravel is unable to automatically serialize the user object(?), so we do it by hand
            session()->set('signup.user', serialize($user));
            return view('auth.finishSignUp', compact('user', 'provider'));
        }
        catch (InvalidModelException $e) {
            return redirect()->action('AuthController@getSignUp')
                             ->with('social_error', true)
                             ->with('provider', $provider)
                             ->withErrors($e->getErrors());
        }
        catch (\Exception $e) {
            \Log::error(class_basename($e).' during social callback ('.printr($_GET).'): ['.$e->getCode().'] '.$e->getMessage());
            $redirect = redirect()
                ->action('AuthController@getSignUp')
                ->with('social_error', true)
                ->with('provider', $provider);
            if ($errors = request()->getSession()->get('errors')) {
                $redirect->withErrors($errors->getBag('default'));
            }
            return $redirect;
        }
    }

    public function postFinishSignUp(SignUpFinish $req) {
        /** @var User $user */
        $user = unserialize(session('signup.user'));

        try {
            \DB::transaction(function() use ($req, $user) {
                if ($req->email) {
                    $user->email = $req->email;
                }
                $user->username = $req->username;
                $user->throwOnValidation = true; //todo: https://github.com/laravel-ardent/ardent/issues/279
                $user->save();
                $this->saveLinks($user, true);
                $this->saveLinks($user);

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
            \Log::error(class_basename($e).' during social auth ('.printr($_GET).'): ['.$e->getCode().'] '.$e->getMessage());
            return redirect()->action('AuthController@getSignUp')
                             ->with('social_error', true)
                             ->with('provider', $req->provider);
        }

        return $this->loginAfterSignUp($user, $req->provider);
    }

    /** @todo going to receive a ping whenever a user deauthorizes in the provider - test with Facebook! */
    public function getDeauth(string $provider) {

    }

/*-******************************  COMMON ROUTES *******************************-*/

    public function getSignUp() {
        $user = new User;
        User::changeRules(User::SC_SIGNUP);
        return view('auth.signUp', compact('user'));
    }

    public function postSignUp(SignUp $req) {
        $user = new User(\Input::except('_token'));
        $user->save();
        return $this->loginAfterSignUp($user);
    }

    public function getLogin() {
        if (!Session::has('url.intended')) {
            Session::put('url.intended', $_SERVER['HTTP_REFERER']?? null);
        }

        return $this->loginBasic();
    }

    public function getLogout() {
        Auth::logout();
        return redirect()->back();
    }
}
