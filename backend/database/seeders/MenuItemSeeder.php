<?php

namespace Database\Seeders;

use App\Infrastructures\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuItem::create([
            'parent_id' => 1,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controller',
            'function' => 'index',
            'route' => 'dashboard.index',
            'endpoint' => '/dashboard',
            'description' => 'Dashboard List View',
            'is_screen' => 1,
            'sort' => 10,
        ]);

        /* Domains */
        MenuItem::create([
            'parent_id' => 2,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controller',
            'function' => 'index',
            'route' => 'domain.index',
            'endpoint' => '/domain',
            'description' => 'Domains List View',
            'is_screen' => 1,
            'sort' => 100,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\DomainController',
            'function' => 'store',
            'route' => 'api.domain.store',
            'endpoint' => '/api/domain',
            'description' => 'Domains Create',
            'is_screen' => 0,
            'sort' => 110,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\DomainController',
            'function' => 'update',
            'route' => 'api.domain.update',
            'endpoint' => '/api/domain',
            'description' => 'Domains Update',
            'is_screen' => 0,
            'sort' => 120,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\DomainController',
            'function' => 'delete',
            'route' => 'api.domain.delete',
            'endpoint' => '/api/domain',
            'description' => 'Domains Delete',
            'is_screen' => 0,
            'sort' => 130,
        ]);

        /* DNS */
        MenuItem::create([
            'parent_id' => 3,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controllers\Controller',
            'function' => 'index',
            'route' => 'dns.index',
            'endpoint' => '/dns',
            'description' => 'DNS List View',
            'is_screen' => 1,
            'sort' => 200,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\DnsController',
            'function' => 'store',
            'route' => 'api.dns.store',
            'endpoint' => '/api/dns',
            'description' => 'DNS Create',
            'is_screen' => 0,
            'sort' => 210,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\DnsController',
            'function' => 'update',
            'route' => 'api.dns.update',
            'endpoint' => '/api/dns',
            'description' => 'DNS Update',
            'is_screen' => 0,
            'sort' => 220,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\DnsController',
            'function' => 'delete',
            'route' => 'api.dns.delete',
            'endpoint' => '/api/dns',
            'description' => 'DNS Delete',
            'is_screen' => 0,
            'sort' => 230,
        ]);

        /* Registrar */
        MenuItem::create([
            'parent_id' => 4,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controllers\Controller',
            'function' => 'index',
            'route' => 'registrar.index',
            'endpoint' => '/registrar',
            'description' => 'Registrar List View',
            'is_screen' => 1,
            'sort' => 300,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\RegistrarController',
            'function' => 'store',
            'route' => 'api.registrar.store',
            'endpoint' => '/api/registrar',
            'description' => 'Registrar Create',
            'is_screen' => 0,
            'sort' => 310,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\RegistrarController',
            'function' => 'update',
            'route' => 'api.registrar.update',
            'endpoint' => '/api/registrar',
            'description' => 'Registrar Update',
            'is_screen' => 0,
            'sort' => 320,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\RegistrarController',
            'function' => 'delete',
            'route' => 'api.registrar.delete',
            'endpoint' => '/api/registrar',
            'description' => 'Registrar Delete',
            'is_screen' => 0,
            'sort' => 330,
        ]);

        /* Client */
        MenuItem::create([
            'parent_id' => 5,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controllers\Controller',
            'function' => 'index',
            'route' => 'client.index',
            'endpoint' => '/client',
            'description' => 'Client List View',
            'is_screen' => 1,
            'sort' => 400,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\ClientController',
            'function' => 'store',
            'route' => 'api.client.store',
            'endpoint' => '/api/client',
            'description' => 'Client Create',
            'is_screen' => 0,
            'sort' => 410,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\ClientController',
            'function' => 'update',
            'route' => 'api.client.update',
            'endpoint' => '/api/client',
            'description' => 'Client Update',
            'is_screen' => 0,
            'sort' => 420,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\ClientController',
            'function' => 'delete',
            'route' => 'api.client.delete',
            'endpoint' => '/api/client',
            'description' => 'Client Delete',
            'is_screen' => 0,
            'sort' => 430,
        ]);

        /* Dealing */
        MenuItem::create([
            'parent_id' => 6,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controllers\Controller',
            'function' => 'index',
            'route' => 'dealing.index',
            'endpoint' => '/dealing',
            'description' => 'Dealing List View',
            'is_screen' => 1,
            'sort' => 500,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'store',
            'route' => 'api.dealing.store',
            'endpoint' => '/api/dealing',
            'description' => 'Dealing Create',
            'is_screen' => 0,
            'sort' => 510,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'update',
            'route' => 'api.dealing.update',
            'endpoint' => '/api/dealing',
            'description' => 'Dealing Update',
            'is_screen' => 0,
            'sort' => 520,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Detail',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'detail',
            'route' => 'api.dealing.detail',
            'endpoint' => '/api/dealing',
            'description' => 'Dealing Detail',
            'is_screen' => 0,
            'sort' => 530,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'delete',
            'route' => 'api.dealing.delete',
            'endpoint' => '/api/dealing',
            'description' => 'Dealing Detail',
            'is_screen' => 0,
            'sort' => 540,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Billing Update',
            'controller' => 'App\Http\Controllers\Api\BillingController',
            'function' => 'update',
            'route' => 'api.dealing.billing.update',
            'endpoint' => '/api/dealing/billing',
            'description' => 'Billing Update',
            'is_screen' => 0,
            'sort' => 550,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Billing Create',
            'controller' => 'App\Http\Controllers\Api\BillingController',
            'function' => 'store',
            'route' => 'api.dealing.billing.store',
            'endpoint' => '/api/dealing/billing',
            'description' => 'Billing Create',
            'is_screen' => 0,
            'sort' => 560,
        ]);

        MenuItem::create([
            'parent_id' => 7,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Api\SettingController',
            'function' => 'index',
            'route' => 'setting.index',
            'endpoint' => '/setting',
            'description' => 'User Setting',
            'is_screen' => 1,
            'sort' => 600,
        ]);

        /* Account */
        MenuItem::create([
            'parent_id' => 8,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Controllers\Controller',
            'function' => 'index',
            'route' => 'account.index',
            'endpoint' => '/account',
            'description' => 'Account List View',
            'is_screen' => 1,
            'sort' => 700,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\AccountController',
            'function' => 'store',
            'route' => 'api.account.store',
            'endpoint' => '/api/account',
            'description' => 'Account Create',
            'is_screen' => 0,
            'sort' => 710,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\AccountController',
            'function' => 'update',
            'route' => 'api.account.update',
            'endpoint' => '/api/account',
            'description' => 'Account Update',
            'is_screen' => 0,
            'sort' => 720,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\AccountController',
            'function' => 'delete',
            'route' => 'api.account.delete',
            'endpoint' => '/api/account',
            'description' => 'Account Delete',
            'is_screen' => 0,
            'sort' => 730,
        ]);

        /* Role */
        MenuItem::create([
            'parent_id' => 9,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\RoleController',
            'function' => 'store',
            'route' => 'api.role.store',
            'endpoint' => '/api/role',
            'description' => 'Role Create',
            'is_screen' => 0,
            'sort' => 740,
        ]);

        MenuItem::create([
            'parent_id' => 9,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\RoleController',
            'function' => 'update',
            'route' => 'api.role.update',
            'endpoint' => '/api/role',
            'description' => 'Role Update',
            'is_screen' => 0,
            'sort' => 750,
        ]);

        MenuItem::create([
            'parent_id' => 9,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\RoleController',
            'function' => 'delete',
            'route' => 'api.role.delete',
            'endpoint' => '/api/role',
            'description' => 'Role Delete',
            'is_screen' => 0,
            'sort' => 760,
        ]);
    }
}
