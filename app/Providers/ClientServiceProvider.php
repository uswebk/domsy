<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\Client\ClientRepository;
use App\Infrastructures\Repositories\Client\ClientRepositoryInterface;

use Illuminate\Support\ServiceProvider;

final class ClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
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
