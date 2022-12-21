<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Domain\Subdomain\Dns;

use App\Models\DnsRecordType;
use App\Models\Domain;
use App\Models\Subdomain;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepository;
use App\Services\Domain\Subdomain\Dns\ApplyRecordService;
use App\Services\Domain\Subdomain\Dns\RecordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

final class ApplyRecordServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('DnsRecordTypeSeeder');
        $this->dnsRecordTypes = DnsRecordType::all()->pluck('name', 'id')->toArray();

        $this->mock = Mockery::mock('\App\Services\Domain\Subdomain\Dns\MakeRecordService');
    }

    /**
     * @test
     */
    public function it_execute(): void
    {
        $dnsRecordsDummy = new Collection();
        $dnsRecordsDummy->push(new RecordService([
            'host' => 'test.com',
            'type' => 'A',
            'ttl' => 100,
            'ip' => '127.0.0.1',
        ]));

        $this->mock->shouldReceive('make')->andReturn($dnsRecordsDummy);

        $domain = Domain::factory(['name' => 'test.com'])->create();
        $subdomains = Subdomain::factory([
            'domain_id' => $domain->id,
            'prefix' => '',
        ])->count(10)->create();

        $apply_record_service = new ApplyRecordService(new SubdomainRepository(), $this->mock);
        $apply_record_service->execute($subdomains, $this->dnsRecordTypes);

        $this->assertDatabaseHas('subdomains', [
            'domain_id' => $domain->id,
            'ttl' => 100,
            'value' => '127.0.0.1',
        ]);

        $this->assertCount(1, $apply_record_service->getSuccessDomains());
        $this->assertEmpty($apply_record_service->getErrorDomains());
    }

    /**
     * @test
     */
    public function it_do_not_execute(): void
    {
        $dnsRecordsDummy = new Collection();

        $this->mock->shouldReceive('make')->andReturn($dnsRecordsDummy);

        $domain = Domain::factory(['name' => 'dummy.test.com'])->create();
        $subdomains = Subdomain::factory([
            'domain_id' => $domain->id,
            'prefix' => '',
        ])->count(10)->create();

        $apply_record_service = new ApplyRecordService(new SubdomainRepository(), $this->mock);
        $apply_record_service->execute($subdomains, $this->dnsRecordTypes);

        $this->assertDatabaseMissing('subdomains', [
            'domain_id' => $domain->id,
            'ttl' => 100,
            'value' => '127.0.0.1',
        ]);

        $this->assertEmpty($apply_record_service->getSuccessDomains());
        $this->assertCount(1, $apply_record_service->getErrorDomains());
    }
}
