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
        'App\Models\Domain' => 'App\Policies\DomainPolicy',
        'App\Models\DomainBilling' => 'App\Policies\DomainBillingPolicy',
        'App\Models\DomainDealing' => 'App\Policies\DomainDealingPolicy',
        'App\Models\Subdomain' => 'App\Policies\DnsPolicy',
        'App\Models\Registrar' => 'App\Policies\RegistrarPolicy',
        'App\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
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
