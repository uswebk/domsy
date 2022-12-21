<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\Dns;

use App\Models\DnsRecordType;

final class RecordService
{
    private $records = [];

    private const DNS_TYPE_VALUE_INDEXES = [
        'A' => 'ip',
        'AAAA' => 'ipv6',
        'MX' => 'target',
        'CNAME' => 'target',
        'NS' => 'target',
        'PTR' => 'target',
        'TXT' => 'txt',
        'SRV' => 'target',
    ];

    /**
     * @param array $dnsRecord
     */
    public function __construct(array $dnsRecord)
    {
        $this->records['host'] = $dnsRecord['host'] ?? '';

        $this->records['class'] = $dnsRecord['class'] ?? '';

        $this->records['type'] = $dnsRecord['type'] ?? '';

        $this->records['ttl'] = $dnsRecord['ttl'] ?? '';

        $this->records['ip'] = $dnsRecord['ip'] ?? '';

        $this->records['ipv6'] = $dnsRecord['ipv6'] ?? '';

        $this->records['target'] = $dnsRecord['target'] ?? '';

        $this->records['txt'] = $dnsRecord['txt'] ?? '';

        $this->records['pri'] = $dnsRecord['pri'] ?? 0;

        $this->records['entries'] = $dnsRecord['entries'] ?? [];
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->records['host'];
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return (int) $this->records['ttl'];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->records['type'];
    }

    /**
     * @return int
     */
    public function getTypeId(): int
    {
        $dnsRecordType = DnsRecordType::where('name', '=', $this->getType())
            ->firstOrFail();

        return $dnsRecordType->id;
    }

    /**
     * @return integer
     */
    public function getPriority(): int
    {
        return (int) $this->records['pri'];
    }

    /**
     * @return array
     */
    private function getDnsTypeValueIndexes(): array
    {
        return self::DNS_TYPE_VALUE_INDEXES;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $dnsTypeValueIndexes = $this->getDnsTypeValueIndexes();

        $index = $dnsTypeValueIndexes[$this->getType()];

        $value = $this->records[$index];

        if (isset($value)) {
            return $value;
        }
    }
}
