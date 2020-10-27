<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class WantJsonMiddleware
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
        if(in_array($request->getMethod(), ["POST", "PUT", "PATCH"])){
            json_decode($request->getContent());
            if (json_last_error() != JSON_ERROR_NONE || !$request->isJson()) {
                return response()->json(["message" => "Request must be json"], 400);
            }

        }

        return $next($request);
    }
}
