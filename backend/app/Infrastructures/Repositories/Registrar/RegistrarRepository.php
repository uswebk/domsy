<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

use App\Models\Registrar;

final class RegistrarRepository implements RegistrarRepositoryInterface
{
    /**
     * @param \App\Models\Registrar $registrar
     * @return \App\Models\Registrar
     */
    public function save(
        \App\Models\Registrar $registrar
    ): \App\Models\Registrar {
        $registrar->save();

        return $registrar;
    }

    /**
     * @param array $attributes
     * @return \App\Models\Registrar
     */
    public function store(array $attributes): \App\Models\Registrar
    {
        $registrar = Registrar::create($attributes);

        return $registrar;
    }

    /**
     * @param \App\Models\Registrar $registrar
     * @return void
     */
    public function delete(\App\Models\Registrar $registrar): void
    {
        $registrar->delete();
    }
}
