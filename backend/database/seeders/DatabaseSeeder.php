<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
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
        $this->call('\Database\Seeders\MenuTypeSeeder');
        $this->call('\Database\Seeders\GeneralSettingCategorySeeder');
        $this->call('\Database\Seeders\CompanySeeder');
        $this->call('\Database\Seeders\RoleSeeder');
        $this->call('\Database\Seeders\MenuSeeder');
        $this->call('\Database\Seeders\MenuItemSeeder');
        $this->call('\Database\Seeders\UserSeeder');
    }
}
