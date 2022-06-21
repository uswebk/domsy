<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Registrar;

interface EloquentRegistrarQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Registrar
     */
    public function firstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Registrar;
}
