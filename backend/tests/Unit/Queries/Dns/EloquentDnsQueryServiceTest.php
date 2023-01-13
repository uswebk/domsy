<?php

declare(strict_types=1);

namespace Tests\Unit\Queries\Dns;

use App\Models\DnsRecordType;
use App\Queries\Dns\EloquentDnsRecordTypeQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentDnsQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfGetSortAll(): array
    {
        return [
            'sort asc' => [
                [['sort' => 10,], ['sort' => 20,],],
                10,
            ],
            'sort desc' => [
                [['sort' => 30,], ['sort' => 20,],],
                20,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetSortAll
     */
    public function it_get_sort_all(array $parameterOfDns, int $assertSort): void
    {
        foreach ($parameterOfDns as $_parameterOfDns) {
            DnsRecordType::factory($_parameterOfDns)->create();
        }

        $dnsRecords = (new EloquentDnsRecordTypeQueryService())->getSortAll();

        $firstDnsRecord = $dnsRecords->first();

        $this->assertSame($assertSort, $firstDnsRecord->sort);
    }
}
