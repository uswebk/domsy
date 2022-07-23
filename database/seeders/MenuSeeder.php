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
            'url_path' => '/dashboard',
            'icon' => 'mdi-monitor-dashboard',
            'is_nav' => 1,
            'sort' => 10,
        ]);

        Menu::create([
            'id' => 2,
            'type_id' => 1,
            'name' => 'Domains',
            'description' => 'Register or renew your domain.',
            'url_path' => '/domain',
            'icon' => 'mdi-database',
            'is_nav' => 1,
            'sort' => 20,
        ]);

        Menu::create([
            'id' => 3,
            'type_id' => 1,
            'name' => 'DNS',
            'description' => 'Set the DNS information of the registered domain',
            'url_path' => '/dns',
            'icon' => 'mdi-web',
            'is_nav' => 1,
            'sort' => 30,
        ]);

        Menu::create([
            'id' => 4,
            'type_id' => 2,
            'name' => 'Registrar',
            'description' => 'Manage domain registrar information.',
            'url_path' => '/registrar',
            'icon' => 'mdi-domain',
            'is_nav' => 1,
            'sort' => 40,
        ]);

        Menu::create([
            'id' => 5,
            'type_id' => 2,
            'name' => 'Client',
            'description' => 'Manage client information.',
            'url_path' => '/registrar',
            'icon' => 'mdi-account-group',
            'is_nav' => 1,
            'sort' => 50,
        ]);

        Menu::create([
            'id' => 6,
            'type_id' => 2,
            'name' => 'Dealing',
            'description' => 'Manage dealing information.',
            'url_path' => '/dealing',
            'icon' => 'mdi-note-edit',
            'is_nav' => 1,
            'sort' => 60,
        ]);

        Menu::create([
            'id' => 7,
            'type_id' => 3,
            'name' => 'Settings',
            'description' => 'User setting',
            'url_path' => '/settings',
            'icon' => 'mdi-cog',
            'is_nav' => 1,
            'sort' => 70,
        ]);
    }
}
