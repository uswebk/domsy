<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Eloquent\MailCategory;
use Illuminate\Database\Seeder;

class MailCategorySeeder extends Seeder
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
            'annotation' => 'お知らせ',
            'is_specify_number_days' => false,
            'default_days' => 0,
            'sort' => 10,
        ]);
        MailCategory::create([
            'id' => 2,
            'name' => 'domain_expiration',
            'annotation' => 'ドメイン有効期限',
            'is_specify_number_days' => true,
            'default_days' => 90,
            'sort' => 20,
        ]);
    }
}
