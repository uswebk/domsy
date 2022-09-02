<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Constants\CompanyConstant;
use App\Constants\RoleConstant;
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
            'id' => RoleConstant::DEFAULT_ROLE_ID,
            'company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID,
            'name' => 'Administrator',
        ]);
    }
}
