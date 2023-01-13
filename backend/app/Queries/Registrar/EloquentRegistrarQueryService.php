<?php

declare(strict_types=1);

namespace App\Queries\Registrar;

use App\Models\Registrar;

final class EloquentRegistrarQueryService implements RegistrarQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\Registrar
     */
    public function firstByIdUserId(int $id, int $userId): \App\Models\Registrar
    {
        return Registrar::where('id', '=', $id)
            ->where('user_id', '=', $userId)
            ->firstOrFail();
    }

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection
    {
        return Registrar::whereIn('user_id', $userIds)->get();
    }
}
