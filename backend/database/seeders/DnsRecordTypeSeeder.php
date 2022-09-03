<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructures\Models\DnsRecordType;

use Illuminate\Database\Seeder;

final class DnsRecordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DnsRecordType::create([
            'name' => 'A',
            'sort' => 10,
        ]);

        DnsRecordType::create([
            'name' => 'AAAA',
            'sort' => 20,
        ]);

        DnsRecordType::create([
            'name' => 'CNAME',
            'sort' => 30,
        ]);

        DnsRecordType::create([
            'name' => 'MX',
            'sort' => 40,
        ]);

        DnsRecordType::create([
            'name' => 'NS',
            'sort' => 50,
        ]);

        DnsRecordType::create([
            'name' => 'TXT',
            'sort' => 60,
        ]);

        DnsRecordType::create([
            'name' => 'SRV',
            'sort' => 70,
        ]);

        DnsRecordType::create([
            'name' => 'DS',
            'sort' => 80,
        ]);

        DnsRecordType::create([
            'name' => 'CAA',
            'sort' => 90,
        ]);
    }
}
