<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

use App\Infrastructures\Models\Eloquent\DomainDnsRecord;

final class DomainDnsRecordRepository implements DomainDnsRecordRepositoryInterface
{
    public function store(array $attributes): DomainDnsRecord
    {
        $domain = DomainDnsRecord::create($attributes);

        return $domain;
    }
}
