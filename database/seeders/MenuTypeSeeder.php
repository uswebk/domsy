<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\MenuType;

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
            'type' => 'network',
            'sort' => 10,
        ]);

        MenuType::create([
            'type' => 'dealing',
            'sort' => 20,
        ]);

        MenuType::create([
            'type' => 'other',
            'sort' => 90,
        ]);
    }
}
