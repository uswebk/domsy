<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\GeneralSettingCategory;
use Illuminate\Database\Seeder;

class GeneralSettingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralSettingCategory::create([
            'id' => 1,
            'name' => 'dns_auto_fetch',
            'annotation' => 'DNS Auto fetch',
            'sort' => 10,
        ]);
    }
}
