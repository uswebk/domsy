<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Registrar;

use App\Infrastructures\Models\Registrar;

final class EloquentRegistrarQueryService implements EloquentRegistrarQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Registrar
     */
    public function firstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Registrar
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
