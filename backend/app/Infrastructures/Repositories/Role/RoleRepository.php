<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Role;

use App\Models\Role;

final class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\Role
     */
    public function store(array $attributes): \App\Models\Role
    {
        $role = Role::create($attributes);

        return $role;
    }

    /**
     * @param \App\Models\Role $role
     * @return void
     */
    public function delete(\App\Models\Role $role): void
    {
        $role->delete();
    }

    /**
     * @param \App\Models\Role $role
     * @return \App\Models\Role
     */
    public function save(\App\Models\Role $role): \App\Models\Role
    {
        $role->save();

        return $role;
    }
}
