<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\MenuType;

use Illuminate\Database\Seeder;

final class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuType::create([
            'id' => 1,
            'type' => 'network',
            'sort' => 10,
        ]);

        MenuType::create([
            'id' => 2,
            'type' => 'dealing',
            'sort' => 20,
        ]);

        MenuType::create([
            'id' => 3,
            'type' => 'other',
            'sort' => 90,
        ]);

        MenuType::create([
            'id' => 4,
            'type' => 'corporation',
            'sort' => 100,
        ]);
    }
}
