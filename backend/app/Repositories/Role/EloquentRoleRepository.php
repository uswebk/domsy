<?php

declare(strict_types=1);

namespace App\Repositories\Role;

use App\Models\Role;

final class EloquentRoleRepository implements RoleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Role
     */
    public function store(array $attributes): Role
    {
        $role = Role::create($attributes);

        return $role;
    }

    /**
     * @param Role $role
     * @return void
     */
    public function delete(Role $role): void
    {
        $role->delete();
    }

    /**
     * @param Role $role
     * @return Role
     */
    public function save(Role $role): Role
    {
        $role->save();

        return $role;
    }
}
