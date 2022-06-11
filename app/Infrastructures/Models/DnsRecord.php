<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

use App\Infrastructures\Models\Eloquent\DnsRecordType;

final class DnsRecord
{
    private $host;

    private $class;

    private $ttl;

    private $type;

    private $txt;

    private $pri;

    private $target;

    private $entries;

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
     * @return string
     */
    public function getValue(): string
    {
        if ($this->type === 'A') {
            return $this->getIp();
        }

        if ($this->type === 'TXT') {
            return $this->getTxt();
        }

        return $this->getTarget();
    }
}
