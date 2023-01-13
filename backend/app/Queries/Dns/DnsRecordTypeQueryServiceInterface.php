<?php

declare(strict_types=1);

namespace App\Queries\Dns;

interface DnsRecordTypeQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSortAll(): \Illuminate\Database\Eloquent\Collection;
}
