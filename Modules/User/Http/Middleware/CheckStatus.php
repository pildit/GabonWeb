<?php
namespace Modules\User\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if(Auth::check() && Auth::user()->status != User::STATUS_ACTIVE){
            Auth::logout();
            return redirect('/login')->with('error_login', lang("user_login_error_status"));
        }
        return $response;
    }
}
