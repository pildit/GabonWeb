<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Cookie;

class AuthenticateWithJwtCookie
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!isset($_COOKIE['jwt'])) {
            $this->unauthenticated($request);
        }

        return $next($request);
    }

    /**
     * Create new authentication exception
     *
     * @param $request
     * @throws AuthenticationException
     */
    protected function unauthenticated($request)
    {
        throw new AuthenticationException(
            'Unauthenticated.', [], $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
