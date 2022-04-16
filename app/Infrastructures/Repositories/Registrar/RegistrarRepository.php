<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

use App\Infrastructures\Models\Eloquent\Registrar;

final class RegistrarRepository implements RegistrarRepositoryInterface
{
    public function store(array $attributes): Registrar
    {
        $registrar = Registrar::create($attributes);

        return $registrar;
    }
}
