<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Eloquent\Domain;

final class EloquentDomainQueryService
{
    public function getFirstByIdUserId(int $id, int $userId): ?Domain
    {
        return Domain::where('id', $id)->where('user_id', $userId)->first();
    }

    public function getFirstByNameUserId(string $name, int $userId): ?Domain
    {
        return Domain::where('name', $name)->where('user_id', $userId)->first();
    }
}
