<?php

declare(strict_types=1);

namespace App\Providers;

use App\Queries\Client\ClientQueryServiceInterface;
use App\Queries\Client\EloquentClientQueryService;
use App\Queries\Dns\DnsRecordTypeQueryServiceInterface;
use App\Queries\Dns\EloquentDnsRecordTypeQueryService;
use App\Queries\Domain\Billing\EloquentBillingQueryService;
use App\Queries\Domain\Billing\EloquentBillingQueryServiceInterface;
use App\Queries\Domain\EloquentDomainQueryService;
use App\Queries\Domain\EloquentDomainQueryServiceInterface;
use App\Queries\Menu\EloquentMenuItemQueryService;
use App\Queries\Menu\EloquentMenuItemQueryServiceInterface;
use App\Queries\Menu\EloquentMenuQueryService;
use App\Queries\Menu\EloquentMenuQueryServiceInterface;
use App\Queries\Registrar\EloquentRegistrarQueryService;
use App\Queries\Registrar\EloquentRegistrarQueryServiceInterface;
use App\Queries\Role\EloquentRoleQueryService;
use App\Queries\Role\EloquentRoleQueryServiceInterface;
use App\Queries\SocialAccount\EloquentSocialAccountQueryService;
use App\Queries\SocialAccount\EloquentSocialAccountQueryServiceInterface;
use App\Queries\User\EloquentUserQueryService;
use App\Queries\User\EloquentUserQueryServiceInterface;
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

        $this->app->bind(ClientQueryServiceInterface::class, function () {
            return new EloquentClientQueryService();
        });

        $this->app->bind(EloquentDomainQueryServiceInterface::class, function () {
            return new EloquentDomainQueryService();
        });

        $this->app->bind(DnsRecordTypeQueryServiceInterface::class, function () {
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
