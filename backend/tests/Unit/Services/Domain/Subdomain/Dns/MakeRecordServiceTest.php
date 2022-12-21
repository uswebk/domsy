<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Domain\Subdomain\Dns;

use App\Models\Domain;
use App\Models\Subdomain;
use App\Services\Domain\Subdomain\Dns\MakeRecordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class MakeRecordServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('DnsRecordTypeSeeder');
    }

    /** @test */
    public function it_make()
    {
        $domain = Domain::factory(['name' => 'example.com'])->create();
        $subdomain = Subdomain::factory([
            'domain_id' => $domain->id,
            'prefix' => '',
        ])->create();
        $domain2 = Domain::factory(['name' => 'yahoo.co.jp'])->create();
        $subdomain2 = Subdomain::factory([
            'domain_id' => $domain2->id,
            'prefix' => 'www',
        ])->create();

        $makeRecordService = new MakeRecordService();
        $result = $makeRecordService->make($subdomain);
        $result2 = $makeRecordService->make($subdomain2);

        $this->assertTrue($result->isNotEmpty());
        $this->assertTrue($result2->isNotEmpty());
    }
}
