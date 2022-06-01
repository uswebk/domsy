<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Queries\Client\EloquentClientQueryService;
use App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface;

use Illuminate\Support\ServiceProvider;

final class QueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentClientQueryServiceInterface::class, function () {
            return new EloquentClientQueryService();
        });

        $this->app->bind(EloquentDomainQueryServiceInterface::class, function () {
            return new EloquentDomainQueryService();
        });
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
