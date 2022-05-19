<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

interface RegistrarRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\Registrar $registrar
     * @return \App\Infrastructures\Models\Eloquent\Registrar
     */
    public function save(\App\Infrastructures\Models\Eloquent\Registrar $registrar): \App\Infrastructures\Models\Eloquent\Registrar;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\Registrar
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\Registrar;

    /**
     * @param \App\Infrastructures\Models\Eloquent\Registrar $registrar
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Eloquent\Registrar $registrar): void;
}
