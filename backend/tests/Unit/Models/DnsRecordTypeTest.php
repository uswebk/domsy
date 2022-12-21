<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\DnsRecordType;
use App\Models\Subdomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DnsRecordTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_subdomain(): void
    {
        $dnsRecordType = DnsRecordType::factory()->create();
        Subdomain::factory([
            'type_id' => $dnsRecordType->id,
        ])->create();

        $this->assertTrue($dnsRecordType->subdomains()->exists());
    }
}
