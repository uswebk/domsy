<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Client;

use App\Infrastructures\Models\Client;
use Illuminate\Database\Eloquent\Collection;

final class EloquentClientQueryService implements EloquentClientQueryServiceInterface
{
    /**
     * @param integer $id
     * @return Client
     */
    public function findById(int $id): Client
    {
        return Client::findOrFail($id);
    }

    /**
     * @param integer $id
     * @param integer $userId
     * @return Client
     */
    public function firstByIdUserId(int $id, int $userId): Client
    {
        return Client::where('id', '=', $id)->where('user_id', '=', $userId)
            ->firstOrFail();
    }

    /**
     * @param array $userIds
     * @return Collection
     */
    public function getByUserIds(array $userIds): Collection
    {
        return Client::whereIn('user_id', $userIds)->get();
    }
}
