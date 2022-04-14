<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\Domain\DomainDnsRecordRepository;
use App\Infrastructures\Repositories\Domain\DomainDnsRecordRepositoryInterface;
use App\Infrastructures\Repositories\Domain\DomainRepository;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;

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
        $this->app->bind(DomainDnsRecordRepositoryInterface::class, DomainDnsRecordRepository::class);
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
