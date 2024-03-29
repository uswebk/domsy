<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\EloquentClientRepository;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Company\EloquentCompanyRepository;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use App\Repositories\Domain\Billing\EloquentBillingRepository;
use App\Repositories\Domain\Dealing\DealingRepositoryInterface;
use App\Repositories\Domain\Dealing\EloquentDealingRepository;
use App\Repositories\Domain\DomainRepositoryInterface;
use App\Repositories\Domain\EloquentDomainRepository;
use App\Repositories\Registrar\EloquentRegistrarRepository;
use App\Repositories\Registrar\RegistrarRepositoryInterface;
use App\Repositories\Role\EloquentRoleItemRepository;
use App\Repositories\Role\EloquentRoleRepository;
use App\Repositories\Role\RoleItemRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\SocialAccount\EloquentSocialAccountRepository;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use App\Repositories\Subdomain\EloquentSubdomainRepository;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Repositories\User\EloquentUserGeneralSettingRepository;
use App\Repositories\User\EloquentUserLatestCodeRepository;
use App\Repositories\User\EloquentUserMailSettingRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserGeneralSettingRepositoryInterface;
use App\Repositories\User\UserLatestCodeRepositoryInterface;
use App\Repositories\User\UserMailSettingRepositoryInterface;
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
            return new EloquentDealingRepository();
        });

        $this->app->bind(BillingRepositoryInterface::class, function () {
            return new EloquentBillingRepository();
        });

        $this->app->bind(DomainRepositoryInterface::class, function () {
            return new EloquentDomainRepository();
        });

        $this->app->bind(RegistrarRepositoryInterface::class, function () {
            return new EloquentRegistrarRepository();
        });

        $this->app->bind(RoleRepositoryInterface::class, function () {
            return new EloquentRoleRepository();
        });

        $this->app->bind(RoleItemRepositoryInterface::class, function () {
            return new EloquentRoleItemRepository();
        });

        $this->app->bind(SubdomainRepositoryInterface::class, function () {
            return new EloquentSubdomainRepository();
        });

        $this->app->bind(UserLatestCodeRepositoryInterface::class, function () {
            return new EloquentUserLatestCodeRepository();
        });

        $this->app->bind(UserMailSettingRepositoryInterface::class, function () {
            return new EloquentUserMailSettingRepository();
        });

        $this->app->bind(UserRepositoryInterface::class, function () {
            return new EloquentUserRepository();
        });

        $this->app->bind(SocialAccountRepositoryInterface::class, function () {
            return new EloquentSocialAccountRepository();
        });

        $this->app->bind(UserGeneralSettingRepositoryInterface::class, function () {
            return new EloquentUserGeneralSettingRepository();
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
