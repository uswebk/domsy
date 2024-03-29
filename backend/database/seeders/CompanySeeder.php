<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Constants\CompanyConstant;
use App\Models\Company;

use Illuminate\Database\Seeder;

final class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'id' => CompanyConstant::INDEPENDENT_COMPANY_ID,
            'name' => 'Domsy',
            'email' => 'info@domsy.com',
            'zip' => '0000000',
            'address' => 'No Address',
            'phone_number' => '00000000000',
        ]);
    }
}
