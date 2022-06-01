<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Dns;

interface EloquentDnsRecordTypeQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSortAll(): \Illuminate\Database\Eloquent\Collection;
}
