<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Queries\Client\EloquentClientQueryService;
use App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryService;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface;
use App\Infrastructures\Queries\Domain\Billing\EloquentBillingQueryService;
use App\Infrastructures\Queries\Domain\Billing\EloquentBillingQueryServiceInterface;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface;
use App\Infrastructures\Queries\Menu\EloquentMenuItemQueryService;
use App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface;
use App\Infrastructures\Queries\Menu\EloquentMenuQueryService;
use App\Infrastructures\Queries\Menu\EloquentMenuQueryServiceInterface;
use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryService;
use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryServiceInterface;
use App\Infrastructures\Queries\Role\EloquentRoleQueryService;
use App\Infrastructures\Queries\Role\EloquentRoleQueryServiceInterface;
use App\Infrastructures\Queries\SocialAccount\EloquentSocialAccountQueryService;
use App\Infrastructures\Queries\SocialAccount\EloquentSocialAccountQueryServiceInterface;
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
        $this->app->bind(EloquentBillingQueryServiceInterface::class, function () {
            return new EloquentBillingQueryService();
        });

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

        $this->app->bind(EloquentMenuQueryServiceInterface::class, function () {
            return new EloquentMenuQueryService();
        });

        $this->app->bind(EloquentMenuItemQueryServiceInterface::class, function () {
            return new EloquentMenuItemQueryService();
        });

        $this->app->bind(EloquentRoleQueryServiceInterface::class, function () {
            return new EloquentRoleQueryService();
        });

        $this->app->bind(EloquentSocialAccountQueryServiceInterface::class, function () {
            return new EloquentSocialAccountQueryService();
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
