<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class DPRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user())
        {
            abort(503, "Unauthorized request");
        }

        if (!Auth::user()->hasRole($role))
        {
            abort(503, "Unauthorized request");
        }
        return $next($request);
    }
}
