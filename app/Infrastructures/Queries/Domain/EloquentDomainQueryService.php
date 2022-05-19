<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Eloquent\Domain;

final class EloquentDomainQueryService
{
    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Eloquent\Domain
     */
    public function getFirstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Eloquent\Domain
    {
        return Domain::where('id', $id)->where('user_id', $userId)
        ->firstOrFail();
    }

    /**
     * @param string $name
     * @param integer $userId
     * @return \App\Infrastructures\Models\Eloquent\Domain
     */
    public function getFirstByNameUserId(string $name, int $userId): \App\Infrastructures\Models\Eloquent\Domain
    {
        return Domain::where('name', $name)->where('user_id', $userId)
        ->firstOrFail();
    }
}
