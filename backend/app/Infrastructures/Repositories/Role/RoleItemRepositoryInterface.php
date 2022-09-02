<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Role;

interface RoleItemRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\RoleItem
     */
    public function store(array $attributes): \App\Infrastructures\Models\RoleItem;

    /**
     * @param integer $roleId
     * @return void
     */
    public function deleteByRoleId(int $roleId): void;
}
