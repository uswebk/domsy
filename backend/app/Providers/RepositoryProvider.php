<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\EloquentClientRepository;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Company\EloquentCompanyRepository;
use App\Repositories\Domain\Billing\BillingRepository;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use App\Repositories\Domain\Dealing\DealingRepository;
use App\Repositories\Domain\Dealing\DealingRepositoryInterface;
use App\Repositories\Domain\DomainRepositoryInterface;
use App\Repositories\Domain\EloquentDomainRepository;
use App\Repositories\Registrar\RegistrarRepository;
use App\Repositories\Registrar\RegistrarRepositoryInterface;
use App\Repositories\Role\RoleItemRepository;
use App\Repositories\Role\RoleItemRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\SocialAccount\SocialAccountRepository;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use App\Repositories\Subdomain\SubdomainRepository;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Repositories\User\UserGeneralSettingRepository;
use App\Repositories\User\UserGeneralSettingRepositoryInterface;
use App\Repositories\User\UserLatestCodeRepository;
use App\Repositories\User\UserLatestCodeRepositoryInterface;
use App\Repositories\User\UserMailSettingRepository;
use App\Repositories\User\UserMailSettingRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, function () {
            return new EloquentClientRepository();
        });

        $this->app->bind(CompanyRepositoryInterface::class, function () {
            return new EloquentCompanyRepository();
        });

        $this->app->bind(DealingRepositoryInterface::class, function () {
            return new DealingRepository();
        });

        $this->app->bind(BillingRepositoryInterface::class, function () {
            return new BillingRepository();
        });

        $this->app->bind(DomainRepositoryInterface::class, function () {
            return new EloquentDomainRepository();
        });

        $this->app->bind(RegistrarRepositoryInterface::class, function () {
            return new RegistrarRepository();
        });

        $this->app->bind(RoleRepositoryInterface::class, function () {
            return new RoleRepository();
        });

        $this->app->bind(RoleItemRepositoryInterface::class, function () {
            return new RoleItemRepository();
        });

        $this->app->bind(SubdomainRepositoryInterface::class, function () {
            return new SubdomainRepository();
        });

        $this->app->bind(UserLatestCodeRepositoryInterface::class, function () {
            return new UserLatestCodeRepository();
        });

        $this->app->bind(UserMailSettingRepositoryInterface::class, function () {
            return new UserMailSettingRepository();
        });

        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserRepository();
        });

        $this->app->bind(SocialAccountRepositoryInterface::class, function () {
            return new SocialAccountRepository();
        });

        $this->app->bind(UserGeneralSettingRepositoryInterface::class, function () {
            return new UserGeneralSettingRepository();
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
