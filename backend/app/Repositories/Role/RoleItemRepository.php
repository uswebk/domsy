<?php

declare(strict_types=1);

namespace App\Repositories\Role;

use App\Models\RoleItem;

final class RoleItemRepository implements RoleItemRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\RoleItem
     */
    public function store(array $attributes): \App\Models\RoleItem
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
