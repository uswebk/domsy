<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Registrar;

use App\Infrastructures\Models\Eloquent\Registrar;

interface RegistrarRepositoryInterface
{
    public function store(array $attributes): Registrar;

    public function save(Registrar $registrar): Registrar;

    public function delete(Registrar $registrar): void;
}
