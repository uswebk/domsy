<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\Client\ClientRepository;
use App\Infrastructures\Repositories\Client\ClientRepositoryInterface;
use App\Infrastructures\Repositories\Dealing\DomainDealingRepository;
use App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface;
use App\Infrastructures\Repositories\Domain\DomainRepository;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Infrastructures\Repositories\Registrar\RegistrarRepository;
use App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepository;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Infrastructures\Repositories\User\UserLatestCodeRepository;
use App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface;
use App\Infrastructures\Repositories\User\UserMailSettingRepository;
use App\Infrastructures\Repositories\User\UserMailSettingRepositoryInterface;
use App\Infrastructures\Repositories\User\UserRepository;
use App\Infrastructures\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(DomainDealingRepositoryInterface::class, DomainDealingRepository::class);
        $this->app->bind(DomainRepositoryInterface::class, DomainRepository::class);
        $this->app->bind(RegistrarRepositoryInterface::class, RegistrarRepository::class);
        $this->app->bind(SubdomainRepositoryInterface::class, SubdomainRepository::class);
        $this->app->bind(UserLatestCodeRepositoryInterface::class, UserLatestCodeRepository::class);
        $this->app->bind(UserMailSettingRepositoryInterface::class, UserMailSettingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
