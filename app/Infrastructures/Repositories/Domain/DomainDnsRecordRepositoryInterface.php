<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

use App\Infrastructures\Models\Eloquent\DomainDnsRecord;

interface DomainDnsRecordRepositoryInterface
{
    public function store(array $attributes): DomainDnsRecord;
}
