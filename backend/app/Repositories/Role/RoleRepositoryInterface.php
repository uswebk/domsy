<?php

declare(strict_types=1);

namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\Role
     */
    public function store(array $attributes): \App\Models\Role;

    /**
     * @param \App\Models\Role $role
     * @return \App\Models\Role
     */
    public function save(\App\Models\Role $role): \App\Models\Role;

    /**
     * @param \App\Models\Role $role
     * @return void
     */
    public function delete(\App\Models\Role $role): void;
}
