<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

interface RegistrarRepositoryInterface
{
    /**
     * @param \App\Models\Registrar $registrar
     * @return \App\Models\Registrar
     */
    public function save(\App\Models\Registrar $registrar): \App\Models\Registrar;

    /**
     * @param array $attributes
     * @return \App\Models\Registrar
     */
    public function store(array $attributes): \App\Models\Registrar;

    /**
     * @param \App\Models\Registrar $registrar
     * @return void
     */
    public function delete(\App\Models\Registrar $registrar): void;
}
