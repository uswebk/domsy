<?php

namespace App\Http\Middleware;

use Closure;

final class RoleMiddleware
{
    public function handle($request, Closure $next, $route = null)
    {
        if ($route !== null && !$request->user()->can($route)) {
            abort(403);
        }

        return $next($request);
    }
}
