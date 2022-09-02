<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

interface RegistrarRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return \App\Infrastructures\Models\Registrar
     */
    public function save(\App\Infrastructures\Models\Registrar $registrar): \App\Infrastructures\Models\Registrar;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Registrar
     */
    public function store(array $attributes): \App\Infrastructures\Models\Registrar;

    /**
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Registrar $registrar): void;
}
