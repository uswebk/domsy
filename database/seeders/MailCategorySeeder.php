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
            'name' => 'domain_expiration',
            'annotation' => 'ドメイン有効期限',
            'sort' => 10,
        ]);
    }
}
