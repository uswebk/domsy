<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Infrastructures\Models\Domain' => 'App\Policies\DomainPolicy',
        'App\Infrastructures\Models\Subdomain' => 'App\Policies\DnsPolicy',
        'App\Infrastructures\Models\Registrar' => 'App\Policies\RegistrarPolicy',
        'App\Infrastructures\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Infrastructures\Models\DomainDealing' => 'App\Policies\DomainDealingPolicy',
        'App\Infrastructures\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
