<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Role;

interface RoleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Role
     */
    public function store(array $attributes): \App\Infrastructures\Models\Role;

    /**
     * @param \App\Infrastructures\Models\Role $role
     * @return \App\Infrastructures\Models\Role
     */
    public function save(\App\Infrastructures\Models\Role $role): \App\Infrastructures\Models\Role;

    /**
     * @param \App\Infrastructures\Models\Role $role
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Role $role): void;
}
