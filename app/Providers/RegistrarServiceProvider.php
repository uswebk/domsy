<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\Registrar\RegistrarRepository;
use App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface;

use Illuminate\Support\ServiceProvider;

final class RegistrarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(RegistrarRepositoryInterface::class, RegistrarRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
