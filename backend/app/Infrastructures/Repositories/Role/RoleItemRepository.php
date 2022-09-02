<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Role;

use App\Infrastructures\Models\RoleItem;

final class RoleItemRepository implements RoleItemRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\RoleItem
     */
    public function store(array $attributes): \App\Infrastructures\Models\RoleItem
    {
        $roleItem = RoleItem::create($attributes);

        return $roleItem;
    }

    /**
     * @param integer $roleId
     * @return void
     */
    public function deleteByRoleId(int $roleId): void
    {
        RoleItem::where('role_id', $roleId)->delete();
    }
}
