<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\Dealing\DomainDealingRepository;
use App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface;

use Illuminate\Support\ServiceProvider;

final class DomainDealingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(DomainDealingRepositoryInterface::class, DomainDealingRepository::class);
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
