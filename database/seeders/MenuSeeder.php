<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'type_id' => 3,
            'name' => 'Dashboard',
            'controller' => 'App\Http\Controllers\Frontend\DashboardController',
            'function' => 'index',
            'route' => 'dashboard.index',
            'description' => 'Dashboard View',
            'is_screen' => 1,
            'sort' => 10,
        ]);

        /* Domains */
        Menu::create([
            'type_id' => 1,
            'name' => 'Domains',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'index',
            'route' => 'domain.index',
            'description' => 'Domains List View',
            'is_screen' => 1,
            'sort' => 20,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'Domains',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'new',
            'route' => 'domain.new',
            'description' => 'Domains New Page View',
            'is_screen' => 0,
            'sort' => 30,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'Domains',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'store',
            'route' => 'domain.store',
            'description' => 'Domains Create',
            'is_screen' => 0,
            'sort' => 40,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'Domains',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'edit',
            'route' => 'domain.edit',
            'description' => 'Domains Edit Page View',
            'is_screen' => 0,
            'sort' => 50,
        ]);
        Menu::create([
            'type_id' => 1,
            'name' => 'Domains',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'update',
            'route' => 'domain.update',
            'description' => 'Domains Update',
            'is_screen' => 0,
            'sort' => 60,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'Domains',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'delete',
            'route' => 'domain.delete',
            'description' => 'Domains Delete',
            'is_screen' => 0,
            'sort' => 70,
        ]);

        /* DNS */
        Menu::create([
            'type_id' => 1,
            'name' => 'DNS',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'index',
            'route' => 'dns.index',
            'description' => 'DNS List View',
            'is_screen' => 1,
            'sort' => 80,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'DNS',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'new',
            'route' => 'dns.new',
            'description' => 'DNS New Page View',
            'is_screen' => 0,
            'sort' => 90,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'DNS',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'store',
            'route' => 'dns.store',
            'description' => 'DNS Create',
            'is_screen' => 0,
            'sort' => 100,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'DNS',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'edit',
            'route' => 'dns.edit',
            'description' => 'DNS Edit Page View',
            'is_screen' => 0,
            'sort' => 110,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'DNS',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'update',
            'route' => 'dns.update',
            'description' => 'DNS Update',
            'is_screen' => 0,
            'sort' => 120,
        ]);

        Menu::create([
            'type_id' => 1,
            'name' => 'DNS',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'delete',
            'route' => 'dns.delete',
            'description' => 'DNS Delete',
            'is_screen' => 0,
            'sort' => 130,
        ]);

        /* Registrar */
        Menu::create([
            'type_id' => 2,
            'name' => 'Registrar',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'index',
            'route' => 'registrar.index',
            'description' => 'Registrar List View',
            'is_screen' => 1,
            'sort' => 140,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Registrar',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'new',
            'route' => 'registrar.new',
            'description' => 'Registrar New Page View',
            'is_screen' => 0,
            'sort' => 150,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Registrar',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'store',
            'route' => 'registrar.store',
            'description' => 'Registrar Create',
            'is_screen' => 0,
            'sort' => 160,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Registrar',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'edit',
            'route' => 'registrar.edit',
            'description' => 'Registrar Edit Page View',
            'is_screen' => 0,
            'sort' => 170,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Registrar',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'update',
            'route' => 'registrar.update',
            'description' => 'Registrar Update',
            'is_screen' => 0,
            'sort' => 180,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Registrar',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'delete',
            'route' => 'registrar.delete',
            'description' => 'Registrar Delete',
            'is_screen' => 0,
            'sort' => 190,
        ]);

        /* Client */
        Menu::create([
            'type_id' => 2,
            'name' => 'Client',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'index',
            'route' => 'client.index',
            'description' => 'Client List View',
            'is_screen' => 1,
            'sort' => 200,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Client',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'new',
            'route' => 'client.new',
            'description' => 'Client New Page View',
            'is_screen' => 0,
            'sort' => 210,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Client',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'store',
            'route' => 'client.store',
            'description' => 'Client Create',
            'is_screen' => 0,
            'sort' => 220,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Client',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'edit',
            'route' => 'client.edit',
            'description' => 'Client Edit Page View',
            'is_screen' => 0,
            'sort' => 230,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Client',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'update',
            'route' => 'client.update',
            'description' => 'Client Update',
            'is_screen' => 0,
            'sort' => 240,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Client',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'delete',
            'route' => 'client.delete',
            'description' => 'Client Delete',
            'is_screen' => 0,
            'sort' => 250,
        ]);

        /* Dealing */
        Menu::create([
            'type_id' => 2,
            'name' => 'Dealing',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'index',
            'route' => 'dealing.index',
            'description' => 'Dealing List View',
            'is_screen' => 1,
            'sort' => 260,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Dealing',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'new',
            'route' => 'dealing.new',
            'description' => 'Dealing New Page View',
            'is_screen' => 0,
            'sort' => 270,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Dealing',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'store',
            'route' => 'dealing.store',
            'description' => 'Dealing Create',
            'is_screen' => 0,
            'sort' => 280,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Dealing',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'edit',
            'route' => 'dealing.edit',
            'description' => 'Dealing Edit Page View',
            'is_screen' => 0,
            'sort' => 290,
        ]);

        Menu::create([
            'type_id' => 2,
            'name' => 'Dealing',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'update',
            'route' => 'dealing.update',
            'description' => 'Client Update',
            'is_screen' => 0,
            'sort' => 300,
        ]);
    }
}
