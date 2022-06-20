<?php

namespace App\Http\Middleware;

use App\Infrastructures\Models\Eloquent\MenuItem;
use Closure;

final class RoleMiddleware
{
    public function handle($request, Closure $next, $route = null)
    {
        $routeItem = MenuItem::where('route', '=', $route)->first();

        if (! isset($routeItem)) {
            return $next($request);
        }

        if ($route !== null && !$request->user()->can($route)) {
            abort(403);
        }

        return $next($request);
    }
}
