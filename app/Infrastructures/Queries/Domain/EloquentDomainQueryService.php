<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Domain;

final class EloquentDomainQueryService implements EloquentDomainQueryServiceInterface
{
    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Domain
    {
        return Domain::where('id', $id)->where('user_id', $userId)
        ->firstOrFail();
    }

    /**
     * @param integer $userId
     * @param string $name
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByUserIdName(int $userId, string $name): \App\Infrastructures\Models\Domain
    {
        return Domain::where('name', $name)->where('user_id', $userId)
        ->firstOrFail();
    }

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection
    {
        return Domain::whereIn('user_id', $userIds)->get();
    }
}
