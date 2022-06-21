<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Constants\CompanyConstants;
use App\Constants\RoleConstants;
use App\Infrastructures\Models\Role;

use Illuminate\Database\Seeder;

final class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => RoleConstants::DEFAULT_ROLE_ID,
            'company_id' => CompanyConstants::INDEPENDENT_COMPANY_ID,
            'name' => 'Administrator',
        ]);
    }
}
