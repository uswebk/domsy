<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\DNS;

use App\Infrastructures\Models\Eloquent\DnsRecordType;

final class RecordService
{
    private $host;

    private $class;

    private $ttl;

    private $type;

    private $txt;

    private $pri;

    private $target;

    private $entries;

    private const DNS_TYPE_VALUE_INDEXES = [
        'A' => 'ip',
        'AAAA' => 'ipv6',
        'MX' => 'target',
        'CNAME' => 'target',
        'NS' => 'target',
        'PTR' => 'target',
        'TXT' => 'target',
        'SRV' => 'target',
    ];

    /**
     * @param array $dnsRecord
     */
    public function __construct(array $dnsRecord)
    {
        $this->host = $dnsRecord['host'];

        $this->class = $dnsRecord['class'];

        $this->ttl = $dnsRecord['ttl'];

        $this->type = $dnsRecord['type'];

        $this->ip = $dnsRecord['ip'] ?? '';

        $this->target = $dnsRecord['target'] ?? '';

        $this->txt = $dnsRecord['txt'] ?? '';

        $this->pri = $dnsRecord['pri'] ?? 0;

        $this->entries = $dnsRecord['entries'] ?? [];
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getTypeId(): int
    {
        $dnsRecordType = DnsRecordType::where('name', '=', $this->type)
        ->firstOrFail();

        return $dnsRecordType->id;
    }

    /**
     * @return string
     */
    public function getTxt(): string
    {
        return $this->txt;
    }

    /**
     * @return array
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @return integer
     */
    public function getPriority(): int
    {
        return $this->pri;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return array
     */
    public function getDnsTypeValueIndexes(): array
    {
        return self::DNS_TYPE_VALUE_INDEXES;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $dnsTypeValueIndexes = $this->getDnsTypeValueIndexes();

        $index = $dnsTypeValueIndexes[$this->type];

        $value = $this->{$index};

        if (isset($value)) {
            return $value;
        }

        return '';
    }
}
