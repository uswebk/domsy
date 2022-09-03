<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Client;

interface EloquentClientQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Client
     */
    public function findById(int $id): \App\Infrastructures\Models\Client;

    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Client
     */
    public function firstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Client;

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection;
}
