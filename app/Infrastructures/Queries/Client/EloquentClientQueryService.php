<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Client;

use App\Infrastructures\Models\Client;

final class EloquentClientQueryService implements EloquentClientQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Client
     */
    public function findById(int $id): \App\Infrastructures\Models\Client
    {
        return Client::findOrFail($id);
    }

    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Client
     */
    public function firstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Client
    {
        return Client::where('id', '=', $id)->where('user_id', '=', $userId)
        ->firstOrFail();
    }
}
