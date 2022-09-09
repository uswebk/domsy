<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Role;

use App\Infrastructures\Models\Role;

final class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Role
     */
    public function store(array $attributes): \App\Infrastructures\Models\Role
    {
        $role = Role::create($attributes);

        return $role;
    }

    /**
     * @param \App\Infrastructures\Models\Role $role
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Role $role): void
    {
        $role->delete();
    }

    /**
     * @param \App\Infrastructures\Models\Role $role
     * @return \App\Infrastructures\Models\Role
     */
    public function save(\App\Infrastructures\Models\Role $role): \App\Infrastructures\Models\Role
    {
        $role->save();

        return $role;
    }
}
