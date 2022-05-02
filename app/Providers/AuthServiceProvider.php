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
        'App\Infrastructures\Models\Eloquent\Domain' => 'App\Policies\DomainPolicy',
        'App\Infrastructures\Models\Eloquent\Subdomain' => 'App\Policies\DnsPolicy',
        'App\Infrastructures\Models\Eloquent\Registrar' => 'App\Policies\RegistrarPolicy',
        'App\Infrastructures\Models\Eloquent\Client' => 'App\Policies\ClientPolicy',
        'App\Infrastructures\Models\Eloquent\DomainDealing' => 'App\Policies\DomainDealingPolicy',
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
