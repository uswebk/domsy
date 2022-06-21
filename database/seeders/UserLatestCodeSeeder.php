<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\UserLatestCode;

use Illuminate\Database\Seeder;

final class UserLatestCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLatestCode::create([
            'code' => 100000,
        ]);
    }
}
