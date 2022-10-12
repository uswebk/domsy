<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\User;

use App\Services\Domain\Subdomain\Dns\RecordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RecordServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->seed('DnsRecordTypeSeeder');
    }

    /**
     * @return array
     */
    public function dataProviderOfGetValue(): array
    {
        return [
            'type A' => [
                [
                    'host' => 'example.com',
                    'class' => 'IN',
                    'ttl' => '4502',
                    'type' => 'A',
                    'ip' => '123.456.789',
                    'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                    'target' => 'ns3.google.com',
                    'txt' => 'spf=xxxxxxx',
                    'pri' => '100',
                    'entries' => [],
                ],
                'A',
                '123.456.789',
            ],
            'type NS' => [
                [
                    'host' => 'example.com',
                    'class' => 'IN',
                    'ttl' => '4502',
                    'type' => 'NS',
                    'ip' => '123.456.789',
                    'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                    'target' => 'ns3.google.com',
                    'txt' => 'spf=xxxxxxx',
                    'pri' => '100',
                    'entries' => [],
                ],
                'NS',
                'ns3.google.com',
            ],
            'type AAAA' => [
                [
                    'host' => 'example.com',
                    'class' => 'IN',
                    'ttl' => '4502',
                    'type' => 'AAAA',
                    'ip' => '123.456.789',
                    'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                    'target' => 'ns3.google.com',
                    'txt' => 'spf=xxxxxxx',
                    'pri' => '100',
                    'entries' => [],
                ],
                'AAAA',
                '1000:test:2000:3333:abcd:0000:0000',
            ],
            'type TXT' => [
                [
                    'host' => 'example.com',
                    'class' => 'IN',
                    'ttl' => '4502',
                    'type' => 'TXT',
                    'ip' => '123.456.789',
                    'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                    'target' => 'ns3.google.com',
                    'txt' => 'spf=xxxxxxx',
                    'pri' => '100',
                    'entries' => [],
                ],
                'TXT',
                'spf=xxxxxxx',
            ],
            'type CNAME' => [
                [
                    'host' => 'example.com',
                    'class' => 'IN',
                    'ttl' => '4502',
                    'type' => 'CNAME',
                    'ip' => '123.456.789',
                    'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                    'target' => 'ns3.google.com',
                    'txt' => 'spf=xxxxxxx',
                    'pri' => '100',
                    'entries' => [],
                ],
                'CNAME',
                'ns3.google.com',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetValue
     *
     */
    public function get_value(
        array $records,
        string $assertType,
        string $assertValue
    ): void {
        $recordService = new RecordService($records);

        $this->assertEquals($recordService->getType(), $assertType);
        $this->assertEquals($recordService->getValue(), $assertValue);
    }

    /**
     * @test
     */
    public function get_host(): void
    {
        $recordService = new RecordService(
            [
                'host' => 'example.com',
                'class' => 'IN',
                'ttl' => '4502',
                'type' => 'CNAME',
                'ip' => '123.456.789',
                'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                'target' => 'ns3.google.com',
                'txt' => 'spf=xxxxxxx',
                'pri' => '100',
                'entries' => [],
            ],
        );

        $this->assertEquals($recordService->getHost(), 'example.com');
    }

    /**
     * @test
     */
    public function get_ttl(): void
    {
        $recordService = new RecordService(
            [
                'host' => 'example.com',
                'class' => 'IN',
                'ttl' => '4502',
                'type' => 'CNAME',
                'ip' => '123.456.789',
                'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                'target' => 'ns3.google.com',
                'txt' => 'spf=xxxxxxx',
                'pri' => '100',
                'entries' => [],
            ],
        );

        $this->assertEquals($recordService->getTtl(), '4502');
    }

    /**
     * @test
     */
    public function get_priority(): void
    {
        $recordService = new RecordService(
            [
                'host' => 'example.com',
                'class' => 'IN',
                'ttl' => '4502',
                'type' => 'CNAME',
                'ip' => '123.456.789',
                'ipv6' => '1000:test:2000:3333:abcd:0000:0000',
                'target' => 'ns3.google.com',
                'txt' => 'spf=xxxxxxx',
                'pri' => '100',
                'entries' => [],
            ],
        );

        $this->assertEquals($recordService->getPriority(), 100);
    }
}
