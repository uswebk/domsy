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
            'controller' => 'App\Http\Controllers\Frontend\DashboardController',
            'function' => 'index',
            'route' => 'dashboard.index',
            'description' => 'Dashboard List View',
            'is_screen' => 1,
            'sort' => 10,
        ]);

        /* Domains */
        MenuItem::create([
            'parent_id' => 2,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'index',
            'route' => 'domains.index',
            'description' => 'Domains List View',
            'is_screen' => 1,
            'sort' => 100,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\DomainController',
            'function' => 'store',
            'route' => 'api.domains.store',
            'description' => 'Domains Create',
            'is_screen' => 0,
            'sort' => 110,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\DomainController',
            'function' => 'update',
            'route' => 'api.domains.update',
            'description' => 'Domains Update',
            'is_screen' => 0,
            'sort' => 120,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\DomainController',
            'function' => 'delete',
            'route' => 'api.domains.delete',
            'description' => 'Domains Delete',
            'is_screen' => 0,
            'sort' => 130,
        ]);

        /* DNS */
        MenuItem::create([
            'parent_id' => 3,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'index',
            'route' => 'dns.index',
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
            'description' => 'DNS Delete',
            'is_screen' => 0,
            'sort' => 230,
        ]);

        /* Registrar */
        MenuItem::create([
            'parent_id' => 4,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'index',
            'route' => 'registrars.index',
            'description' => 'Registrar List View',
            'is_screen' => 1,
            'sort' => 300,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\RegistrarController',
            'function' => 'store',
            'route' => 'api.registrars.store',
            'description' => 'Registrar Create',
            'is_screen' => 0,
            'sort' => 310,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\RegistrarController',
            'function' => 'update',
            'route' => 'api.registrars.update',
            'description' => 'Registrar Update',
            'is_screen' => 0,
            'sort' => 320,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\RegistrarController',
            'function' => 'delete',
            'route' => 'api.registrars.delete',
            'description' => 'Registrar Delete',
            'is_screen' => 0,
            'sort' => 330,
        ]);

        /* Client */
        MenuItem::create([
            'parent_id' => 5,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'index',
            'route' => 'clients.index',
            'description' => 'Client List View',
            'is_screen' => 1,
            'sort' => 400,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\ClientController',
            'function' => 'store',
            'route' => 'api.clients.store',
            'description' => 'Client Create',
            'is_screen' => 0,
            'sort' => 410,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\ClientController',
            'function' => 'update',
            'route' => 'api.clients.update',
            'description' => 'Client Update',
            'is_screen' => 0,
            'sort' => 420,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\ClientController',
            'function' => 'delete',
            'route' => 'api.clients.delete',
            'description' => 'Client Delete',
            'is_screen' => 0,
            'sort' => 430,
        ]);

        /* Dealing */
        MenuItem::create([
            'parent_id' => 6,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'index',
            'route' => 'dealings.index',
            'description' => 'Dealing List View',
            'is_screen' => 1,
            'sort' => 500,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'store',
            'route' => 'api.dealings.store',
            'description' => 'Dealing Create',
            'is_screen' => 0,
            'sort' => 510,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'update',
            'route' => 'api.dealings.update',
            'description' => 'Dealing Update',
            'is_screen' => 0,
            'sort' => 520,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Detail',
            'controller' => 'App\Http\Controllers\Api\DealingController',
            'function' => 'detail',
            'route' => 'api.dealings.detail',
            'description' => 'Dealing Detail',
            'is_screen' => 0,
            'sort' => 530,
        ]);

        MenuItem::create([
            'parent_id' => 7,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\SettingController',
            'function' => 'index',
            'route' => 'settings.index',
            'description' => 'User Setting',
            'is_screen' => 1,
            'sort' => 600,
        ]);

        /* Account */
        MenuItem::create([
            'parent_id' => 8,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\AccountController',
            'function' => 'index',
            'route' => 'accounts.index',
            'description' => 'Account List View',
            'is_screen' => 1,
            'sort' => 700,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\AccountController',
            'function' => 'store',
            'route' => 'api.accounts.store',
            'description' => 'Account Create',
            'is_screen' => 0,
            'sort' => 710,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\AccountController',
            'function' => 'update',
            'route' => 'api.accounts.update',
            'description' => 'Account Update',
            'is_screen' => 0,
            'sort' => 720,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\AccountController',
            'function' => 'delete',
            'route' => 'api.accounts.delete',
            'description' => 'Account Delete',
            'is_screen' => 0,
            'sort' => 730,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Api\RoleController',
            'function' => 'store',
            'route' => 'api.roles.store',
            'description' => 'Role Create',
            'is_screen' => 0,
            'sort' => 740,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Api\RoleController',
            'function' => 'update',
            'route' => 'api.roles.update',
            'description' => 'Role Update',
            'is_screen' => 0,
            'sort' => 750,
        ]);

        MenuItem::create([
            'parent_id' => 8,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Api\RoleController',
            'function' => 'delete',
            'route' => 'api.roles.delete',
            'description' => 'Role Delete',
            'is_screen' => 0,
            'sort' => 760,
        ]);
    }
}
