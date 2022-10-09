<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\Menu;

use Illuminate\Database\Seeder;

final class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'id' => 1,
            'type_id' => 3,
            'name' => 'Dashboard',
            'description' => '',
            'icon' => 'mdi-monitor-dashboard',
            'is_nav' => 1,
            'sort' => 10,
        ]);

        Menu::create([
            'id' => 2,
            'type_id' => 1,
            'name' => 'Domains',
            'description' => 'Register or renew your domain.',
            'icon' => 'mdi-database',
            'is_nav' => 1,
            'sort' => 20,
        ]);

        Menu::create([
            'id' => 3,
            'type_id' => 1,
            'name' => 'DNS',
            'description' => 'Set the DNS information of the registered domain',
            'icon' => 'mdi-web',
            'is_nav' => 1,
            'sort' => 30,
        ]);

        Menu::create([
            'id' => 4,
            'type_id' => 2,
            'name' => 'Registrar',
            'description' => 'Manage domain registrar information.',
            'icon' => 'mdi-domain',
            'is_nav' => 1,
            'sort' => 40,
        ]);

        Menu::create([
            'id' => 5,
            'type_id' => 2,
            'name' => 'Client',
            'description' => 'Manage client information.',
            'icon' => 'mdi-account-group',
            'is_nav' => 1,
            'sort' => 50,
        ]);

        Menu::create([
            'id' => 6,
            'type_id' => 2,
            'name' => 'Dealing',
            'description' => 'Manage dealing information.',
            'icon' => 'mdi-handshake',
            'is_nav' => 1,
            'sort' => 60,
        ]);

        Menu::create([
            'id' => 7,
            'type_id' => 2,
            'name' => 'Billing',
            'description' => 'Manage billing information.',
            'icon' => 'mdi-handshake',
            'is_nav' => 0,
            'sort' => 70,
        ]);

        Menu::create([
            'id' => 8,
            'type_id' => 3,
            'name' => 'Settings',
            'description' => 'User setting',
            'icon' => 'mdi-cog',
            'is_nav' => 1,
            'sort' => 80,
        ]);

        Menu::create([
            'id' => 9,
            'type_id' => 4,
            'name' => 'Account',
            'description' => 'Manage accounts',
            'icon' => 'mdi-account-multiple',
            'is_nav' => 1,
            'sort' => 90,
        ]);

        Menu::create([
            'id' => 10,
            'type_id' => 4,
            'name' => 'Role',
            'description' => 'Manage roles',
            'icon' => 'mdi-card-account-details',
            'is_nav' => 0,
            'sort' => 100,
        ]);
    }
}
