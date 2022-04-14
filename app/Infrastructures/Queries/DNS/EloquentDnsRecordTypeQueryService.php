<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\DNS;

use App\Infrastructures\Models\Eloquent\DnsRecordType;

final class EloquentDnsRecordTypeQueryService
{
    private $model;

    public function __construct(DnsRecordType $dnsRecordType)
    {
        $this->model = $dnsRecordType;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->orderBy('sort')->get();
    }
}
