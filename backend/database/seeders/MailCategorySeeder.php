<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\MailCategory;

use Illuminate\Database\Seeder;

final class MailCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailCategory::create([
            'id' => 1,
            'name' => 'notification',
            'annotation' => 'News',
            'is_specify_number_days' => false,
            'default_days' => 0,
            'sort' => 10,
        ]);
        MailCategory::create([
            'id' => 2,
            'name' => 'domain_expiration',
            'annotation' => 'Domain Expiration',
            'is_specify_number_days' => true,
            'default_days' => 90,
            'sort' => 20,
        ]);
    }
}
