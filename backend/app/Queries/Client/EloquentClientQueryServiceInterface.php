<?php

declare(strict_types=1);

namespace App\Queries\Client;

interface EloquentClientQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\Client
     */
    public function findById(int $id): \App\Models\Client;

    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Models\Client
     */
    public function firstByIdUserId(int $id, int $userId): \App\Models\Client;

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection;
}
