<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Constants\CompanyConstant;
use App\Constants\RoleConstant;
use App\Infrastructures\Models\User;

use Carbon\Carbon;

use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
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
            'company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID,
            'role_id' => RoleConstant::DEFAULT_ROLE_ID,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '$2y$10$KqpJK5/P2CJUyh4ZSkple.jTh6wFluQNA3/9sIUusug3fUYk9b7hC',
            'emoji' => '128512',
            'email_verify_token' => 'dGVzdEBleGFtcGxlLmNvbQ==',
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
