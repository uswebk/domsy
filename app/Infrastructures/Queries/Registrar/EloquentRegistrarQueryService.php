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
    public function findById(int $id): \App\Infrastructures\Models\Eloquent\Registrar
    {
        return Registrar::findOrFail($id);
    }
}
