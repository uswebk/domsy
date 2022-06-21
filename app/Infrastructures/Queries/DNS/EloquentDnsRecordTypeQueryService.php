<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Dns;

use App\Infrastructures\Models\DnsRecordType;

final class EloquentDnsRecordTypeQueryService implements EloquentDnsRecordTypeQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Collection
     */
    public function getSortAll(): \Illuminate\Database\Collection
    {
        return DnsRecordType::orderBy('sort')->get();
    }
}
