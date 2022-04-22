<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Dns;

use App\Infrastructures\Models\Eloquent\DnsRecordType;

final class EloquentDnsRecordTypeQueryService
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return DnsRecordType::orderBy('sort')->get();
    }
}
