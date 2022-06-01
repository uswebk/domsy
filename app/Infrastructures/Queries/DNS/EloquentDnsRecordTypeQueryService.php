<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Dns;

use App\Infrastructures\Models\Eloquent\DnsRecordType;

final class EloquentDnsRecordTypeQueryService implements EloquentDnsRecordTypeQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSortAll(): \Illuminate\Database\Eloquent\Collection
    {
        return DnsRecordType::orderBy('sort')->get();
    }
}
