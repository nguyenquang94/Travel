<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class DPPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!Auth::user())
        {
            abort(503, "Unauthorized request");
        }

        if (!Auth::user()->hasPermission($permission))
        {
            abort(503, "Unauthorized request");
        }
        return $next($request);
    }
}
