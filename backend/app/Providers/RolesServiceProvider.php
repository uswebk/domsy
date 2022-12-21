<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\MenuItem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class RolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            MenuItem::get()->map(function (
                \App\Models\MenuItem $item
            ) {
                $route = $item->route;

                Gate::define($route, function (\App\Models\User $user) use ($route) {
                    return $user->hasRoleItem($route);
                });
            });
        } catch (\Exception $e) {
            return false;
        }
    }
}
