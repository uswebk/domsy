<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructures\Repositories\User\UserLatestCodeRepository;
use App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface;

use Illuminate\Support\ServiceProvider;

final class UserLatestCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(UserLatestCodeRepositoryInterface::class, UserLatestCodeRepository::class);
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
