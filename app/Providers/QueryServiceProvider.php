<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Queries\Client\EloquentClientQueryService;
use App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryService;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface;
use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryService;
use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryServiceInterface;
use App\Infrastructures\Queries\User\EloquentUserQueryService;
use App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface;

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

        $this->app->bind(EloquentDnsRecordTypeQueryServiceInterface::class, function () {
            return new EloquentDnsRecordTypeQueryService();
        });

        $this->app->bind(EloquentRegistrarQueryServiceInterface::class, function () {
            return new EloquentRegistrarQueryService();
        });

        $this->app->bind(EloquentUserQueryServiceInterface::class, function () {
            return new EloquentUserQueryService();
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
