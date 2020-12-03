<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PermissionMiddleware
{
    use GetsJwtToken;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission, $guard = null)
    {
        throw_if(!$this->getToken($request), new HttpException(403, 'User is not logged in.'));

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            if(collect($this->jwtPayload('data')['permissions'])->contains($permission)) {
                return $next($request);
            }
        }

        throw new HttpException(403,'forbidden');
    }
}
