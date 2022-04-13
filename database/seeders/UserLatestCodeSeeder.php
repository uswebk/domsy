<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\UserLatestCode;
use Illuminate\Database\Seeder;

class UserLatestCodeSeeder extends Seeder
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
