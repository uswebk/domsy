<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

interface EloquentDomainQueryServiceInterface
{
    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Domain;

    /**
     * @param integer $userId
     * @param string $name
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByUserIdName(int $userId, string $name): \App\Infrastructures\Models\Domain;

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection;
}
