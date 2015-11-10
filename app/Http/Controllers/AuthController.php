<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    public function getSignUp() {
        $user = new User;
        return view('auth.signUp', compact('user'));
    }

    public function postSignUp(UserReq $req) {
        $user = new User($_POST);
        !ddd($user);
    }
}