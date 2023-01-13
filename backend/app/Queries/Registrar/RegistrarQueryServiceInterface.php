<?php

declare(strict_types=1);

namespace App\Queries\Registrar;

interface RegistrarQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\Registrar
     */
    public function firstByIdUserId(int $id, int $userId): \App\Models\Registrar;

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection;
}
