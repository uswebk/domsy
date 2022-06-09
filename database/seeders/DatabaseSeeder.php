<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('\Database\Seeders\UserLatestCodeSeeder');
        $this->call('\Database\Seeders\DnsRecordTypeSeeder');
        $this->call('\Database\Seeders\MailCategorySeeder');
        $this->call('\Database\Seeders\UserSeeder');
        $this->call('\Database\Seeders\MenuTypeSeeder');
    }
}
