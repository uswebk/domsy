<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\User;

use App\Infrastructures\Models\DnsRecordType;
use App\Infrastructures\Models\Subdomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DnsRecordTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_subdomain(): void
    {
        $dnsRecordType = DnsRecordType::factory()->create();
        Subdomain::factory([
            'type_id' => $dnsRecordType->id
        ])->create();

        $hoge = $dnsRecordType->subdomains;
        $this->assertTrue($dnsRecordType->subdomains()->exists());
    }
}
