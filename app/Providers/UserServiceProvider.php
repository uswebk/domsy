<?php

declare(strict_types=1);

namespace App\Providers;

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
        //
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserMailSettingRepositoryInterface::class, UserMailSettingRepository::class);
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
