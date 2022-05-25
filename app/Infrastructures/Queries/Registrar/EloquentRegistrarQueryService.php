<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Registrar;

use App\Infrastructures\Models\Eloquent\Registrar;

final class EloquentRegistrarQueryService
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Eloquent\Registrar
     */
    public function firstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Eloquent\Registrar
    {
        return Registrar::where('id', '=', $id)
        ->where('user_id', '=', $userId)
        ->first();
    }
}
