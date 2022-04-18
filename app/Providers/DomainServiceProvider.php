<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\Domain\DomainRepository;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepository;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;

use Illuminate\Support\ServiceProvider;

final class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(DomainRepositoryInterface::class, DomainRepository::class);
        $this->app->bind(SubdomainRepositoryInterface::class, SubdomainRepository::class);
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
