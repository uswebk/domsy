<?php

declare(strict_types=1);

namespace App\Providers;

use App\Queries\Client\ClientQueryServiceInterface;
use App\Queries\Client\EloquentClientQueryService;
use App\Queries\Dns\DnsRecordTypeQueryServiceInterface;
use App\Queries\Dns\EloquentDnsRecordTypeQueryService;
use App\Queries\Domain\Billing\BillingQueryServiceInterface;
use App\Queries\Domain\Billing\EloquentBillingQueryService;
use App\Queries\Domain\DomainQueryServiceInterface;
use App\Queries\Domain\EloquentDomainQueryService;
use App\Queries\Menu\EloquentMenuItemQueryService;
use App\Queries\Menu\EloquentMenuQueryService;
use App\Queries\Menu\MenuItemQueryServiceInterface;
use App\Queries\Menu\MenuQueryServiceInterface;
use App\Queries\Registrar\EloquentRegistrarQueryService;
use App\Queries\Registrar\RegistrarQueryServiceInterface;
use App\Queries\Role\EloquentRoleQueryService;
use App\Queries\Role\RoleQueryServiceInterface;
use App\Queries\SocialAccount\EloquentSocialAccountQueryService;
use App\Queries\SocialAccount\SocialAccountQueryServiceInterface;
use App\Queries\User\EloquentUserQueryService;
use App\Queries\User\UserQueryServiceInterface;
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
        $this->app->bind(BillingQueryServiceInterface::class, function () {
            return new EloquentBillingQueryService();
        });

        $this->app->bind(ClientQueryServiceInterface::class, function () {
            return new EloquentClientQueryService();
        });

        $this->app->bind(DomainQueryServiceInterface::class, function () {
            return new EloquentDomainQueryService();
        });

        $this->app->bind(DnsRecordTypeQueryServiceInterface::class, function () {
            return new EloquentDnsRecordTypeQueryService();
        });

        $this->app->bind(RegistrarQueryServiceInterface::class, function () {
            return new EloquentRegistrarQueryService();
        });

        $this->app->bind(UserQueryServiceInterface::class, function () {
            return new EloquentUserQueryService();
        });

        $this->app->bind(MenuQueryServiceInterface::class, function () {
            return new EloquentMenuQueryService();
        });

        $this->app->bind(MenuItemQueryServiceInterface::class, function () {
            return new EloquentMenuItemQueryService();
        });

        $this->app->bind(RoleQueryServiceInterface::class, function () {
            return new EloquentRoleQueryService();
        });

        $this->app->bind(SocialAccountQueryServiceInterface::class, function () {
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
