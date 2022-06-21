<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

use App\Infrastructures\Models\Registrar;

final class RegistrarRepository implements RegistrarRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return \App\Infrastructures\Models\Registrar
     */
    public function save(
        \App\Infrastructures\Models\Registrar $registrar
    ): \App\Infrastructures\Models\Registrar {
        $registrar->save();

        return $registrar;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Registrar
     */
    public function store(array $attributes): \App\Infrastructures\Models\Registrar
    {
        $registrar = Registrar::create($attributes);

        return $registrar;
    }

    /**
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Registrar $registrar): void
    {
        $registrar->delete();
    }
}
