<?php
namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Authenticate {

    /** @var Guard */
    protected $auth;

    /**
     * @param  Guard $auth
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * @param  Request $request
     * @param  callable $next
     * @return mixed
     */
    public function handle($request, callable $next) {
        if ($this->auth->guest()) {
            return $request->ajax()? response('Unauthorized', 401) : redirect()->guest('auth/login');
        }

        return $next($request);
    }
}
