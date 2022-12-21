<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\DnsRecordType;
use App\Models\Domain;
use App\Models\Subdomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SubdomainTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_domain()
    {
        $subdomain = Subdomain::factory()->for(Domain::factory())->create();

        $this->assertTrue($subdomain->domain()->exists());
    }

    /** @test */
    public function it_has_dns_record_type()
    {
        $subdomain = Subdomain::factory()->for(DnsRecordType::factory())->create();

        $this->assertTrue($subdomain->dnsRecordType()->exists());
    }

    /** @test */
    public function it_get_domain_name()
    {
        $name = 'domsy.com';
        $subdomain = Subdomain::factory()->for(Domain::factory([
            'name' => $name,
        ]))->create();

        $this->assertSame($subdomain->getDomainName(), $name);
    }

    /** @test */
    public function it_get_full_domain_name_when_has_prefix()
    {
        $prefix = 'dev';
        $name = 'domsy.com';
        $subdomain = Subdomain::factory(['prefix' => $prefix])->for(Domain::factory([
            'name' => $name,
        ]))->create();

        $this->assertSame($subdomain->getFullDomainName(), $prefix . '.' . $name);
    }

    /** @test */
    public function it_get_full_domain_name_when_has_not_prefix()
    {
        $name = 'domsy.com';
        $subdomain = Subdomain::factory(['prefix' => ''])->for(Domain::factory([
            'name' => $name,
        ]))->create();

        $this->assertSame($subdomain->getFullDomainName(), $name);
    }
}
