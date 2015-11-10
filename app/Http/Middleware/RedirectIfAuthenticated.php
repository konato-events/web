<?php
namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class RedirectIfAuthenticated {

    /** @var Guard */
    protected $auth;

    /**
     * Create a new filter instance.
     * @param  Guard $auth
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * @param  Request  $request
     * @param  callable $next
     * @return mixed
     */
    public function handle($request, callable $next) {
        if ($this->auth->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
