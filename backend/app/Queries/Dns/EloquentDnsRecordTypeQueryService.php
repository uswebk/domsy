<?php

declare(strict_types=1);

namespace App\Queries\Dns;

use App\Models\DnsRecordType;

final class EloquentDnsRecordTypeQueryService implements DnsRecordTypeQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSortAll(): \Illuminate\Database\Eloquent\Collection
    {
        return DnsRecordType::orderBy('sort')->get();
    }
}
