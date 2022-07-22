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
            'is_nav' => 0,
            'sort' => 10,
        ]);

        Menu::create([
            'id' => 2,
            'type_id' => 1,
            'name' => 'Domains',
            'description' => 'Register or renew your domain.',
            'is_nav' => 1,
            'sort' => 20,
        ]);

        Menu::create([
            'id' => 3,
            'type_id' => 1,
            'name' => 'DNS',
            'description' => 'Set the DNS information of the registered domain',
            'is_nav' => 1,
            'sort' => 30,
        ]);

        Menu::create([
            'id' => 4,
            'type_id' => 2,
            'name' => 'Registrar',
            'description' => 'Manage domain registrar information.',
            'is_nav' => 1,
            'sort' => 40,
        ]);

        Menu::create([
            'id' => 5,
            'type_id' => 2,
            'name' => 'Client',
            'description' => 'Manage client information.',
            'is_nav' => 1,
            'sort' => 50,
        ]);

        Menu::create([
            'id' => 6,
            'type_id' => 2,
            'name' => 'Dealing',
            'description' => 'Manage dealing information.',
            'is_nav' => 1,
            'sort' => 60,
        ]);

        Menu::create([
            'id' => 7,
            'type_id' => 3,
            'name' => 'Settings',
            'description' => 'user setting',
            'is_nav' => 0,
            'sort' => 70,
        ]);
    }
}
