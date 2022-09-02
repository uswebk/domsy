<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\GeneralSettingCategory;
use Illuminate\Database\Seeder;

final class GeneralSettingCategorySeeder extends Seeder
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
            'annotation' => 'DNS Auto Fetch',
            'sort' => 10,
        ]);
    }
}
