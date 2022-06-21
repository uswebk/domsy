<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Models\Eloquent\MenuItem;

use Illuminate\Support\Facades\Blade;
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
            MenuItem::get()->map(function ($item) {
                $route = $item->route;

                Gate::define($route, function ($user) use ($route) {
                    return $user->hasRoleItem($route);
                });
            });
        } catch (\Exception $e) {
            \Log::error(__FILE__ . ' (' . __LINE__ . ')' . PHP_EOL . $e->getMessage());
            return false;
        }

        Blade::directive('role', function ($route) {
            return "if(auth()->check() && auth()->user()->hasRoleItem({$route})) :";
        });

        Blade::directive('endrole', function ($role) {
            return 'endif;';
        });
    }
}
