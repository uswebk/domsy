<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'code' => 100000,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '$2y$10$KqpJK5/P2CJUyh4ZSkple.jTh6wFluQNA3/9sIUusug3fUYk9b7hC',
            'email_verify_token' => 'dGVzdEBleGFtcGxlLmNvbQ==',
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
