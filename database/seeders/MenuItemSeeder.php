<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\MenuItem;
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
            'route' => 'domain.index',
            'description' => 'Domains List View',
            'is_screen' => 1,
            'sort' => 20,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'New',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'new',
            'route' => 'domain.new',
            'description' => 'Domains New Page View',
            'is_screen' => 1,
            'sort' => 30,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'store',
            'route' => 'domain.store',
            'description' => 'Domains Create',
            'is_screen' => 0,
            'sort' => 40,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Edit',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'edit',
            'route' => 'domain.edit',
            'description' => 'Domains Edit Page View',
            'is_screen' => 0,
            'sort' => 50,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'update',
            'route' => 'domain.update',
            'description' => 'Domains Update',
            'is_screen' => 0,
            'sort' => 60,
        ]);

        MenuItem::create([
            'parent_id' => 2,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Frontend\DomainController',
            'function' => 'delete',
            'route' => 'domain.delete',
            'description' => 'Domains Delete',
            'is_screen' => 0,
            'sort' => 70,
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
            'sort' => 80,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'New',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'new',
            'route' => 'dns.new',
            'description' => 'DNS New Page View',
            'is_screen' => 1,
            'sort' => 90,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'store',
            'route' => 'dns.store',
            'description' => 'DNS Create',
            'is_screen' => 0,
            'sort' => 100,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Edit',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'edit',
            'route' => 'dns.edit',
            'description' => 'DNS Edit Page View',
            'is_screen' => 0,
            'sort' => 110,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'update',
            'route' => 'dns.update',
            'description' => 'DNS Update',
            'is_screen' => 0,
            'sort' => 120,
        ]);

        MenuItem::create([
            'parent_id' => 3,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Frontend\DnsController',
            'function' => 'delete',
            'route' => 'dns.delete',
            'description' => 'DNS Delete',
            'is_screen' => 0,
            'sort' => 130,
        ]);

        /* Registrar */
        MenuItem::create([
            'parent_id' => 4,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'index',
            'route' => 'registrar.index',
            'description' => 'Registrar List View',
            'is_screen' => 1,
            'sort' => 140,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'New',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'new',
            'route' => 'registrar.new',
            'description' => 'Registrar New Page View',
            'is_screen' => 1,
            'sort' => 150,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'store',
            'route' => 'registrar.store',
            'description' => 'Registrar Create',
            'is_screen' => 0,
            'sort' => 160,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Edit',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'edit',
            'route' => 'registrar.edit',
            'description' => 'Registrar Edit Page View',
            'is_screen' => 0,
            'sort' => 170,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'update',
            'route' => 'registrar.update',
            'description' => 'Registrar Update',
            'is_screen' => 0,
            'sort' => 180,
        ]);

        MenuItem::create([
            'parent_id' => 4,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Frontend\RegistrarController',
            'function' => 'delete',
            'route' => 'registrar.delete',
            'description' => 'Registrar Delete',
            'is_screen' => 0,
            'sort' => 190,
        ]);

        /* Client */
        MenuItem::create([
            'parent_id' => 5,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'index',
            'route' => 'client.index',
            'description' => 'Client List View',
            'is_screen' => 1,
            'sort' => 200,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'New',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'new',
            'route' => 'client.new',
            'description' => 'Client New Page View',
            'is_screen' => 1,
            'sort' => 210,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'store',
            'route' => 'client.store',
            'description' => 'Client Create',
            'is_screen' => 0,
            'sort' => 220,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Edit',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'edit',
            'route' => 'client.edit',
            'description' => 'Client Edit Page View',
            'is_screen' => 0,
            'sort' => 230,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'update',
            'route' => 'client.update',
            'description' => 'Client Update',
            'is_screen' => 0,
            'sort' => 240,
        ]);

        MenuItem::create([
            'parent_id' => 5,
            'name' => 'Delete',
            'controller' => 'App\Http\Controllers\Frontend\ClientController',
            'function' => 'delete',
            'route' => 'client.delete',
            'description' => 'Client Delete',
            'is_screen' => 0,
            'sort' => 250,
        ]);

        /* Dealing */
        MenuItem::create([
            'parent_id' => 6,
            'name' => 'List',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'index',
            'route' => 'dealing.index',
            'description' => 'Dealing List View',
            'is_screen' => 1,
            'sort' => 260,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'New',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'new',
            'route' => 'dealing.new',
            'description' => 'Dealing New Page View',
            'is_screen' => 1,
            'sort' => 270,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Create',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'store',
            'route' => 'dealing.store',
            'description' => 'Dealing Create',
            'is_screen' => 0,
            'sort' => 280,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Edit',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'edit',
            'route' => 'dealing.edit',
            'description' => 'Dealing Edit Page View',
            'is_screen' => 0,
            'sort' => 290,
        ]);

        MenuItem::create([
            'parent_id' => 6,
            'name' => 'Update',
            'controller' => 'App\Http\Controllers\Frontend\DealingController',
            'function' => 'update',
            'route' => 'dealing.update',
            'description' => 'Client Update',
            'is_screen' => 0,
            'sort' => 300,
        ]);
    }
}
