<?php

declare(strict_types=1);

namespace App\Repositories\Registrar;

use App\Models\Registrar;

final class EloquentRegistrarRepository implements RegistrarRepositoryInterface
{
    /**
     * @param Registrar $registrar
     * @return Registrar
     */
    public function save(Registrar $registrar): Registrar
    {
        $registrar->save();

        return $registrar;
    }

    /**
     * @param array $attributes
     * @return Registrar
     */
    public function store(array $attributes): Registrar
    {
        $registrar = Registrar::create($attributes);

        return $registrar;
    }

    /**
     * @param Registrar $registrar
     * @return void
     */
    public function delete(Registrar $registrar): void
    {
        $registrar->delete();
    }
}
