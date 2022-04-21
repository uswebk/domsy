<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Registrar;

use App\Infrastructures\Models\Eloquent\Registrar;

final class EloquentRegistrarQueryService
{
    public function findById(int $id): Registrar
    {
        return Registrar::findOrFail($id);
    }
}
