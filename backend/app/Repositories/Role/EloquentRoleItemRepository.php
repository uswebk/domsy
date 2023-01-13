<?php

declare(strict_types=1);

namespace App\Repositories\Role;

use App\Models\RoleItem;

final class EloquentRoleItemRepository implements RoleItemRepositoryInterface
{
    /**
     * @param array $attributes
     * @return RoleItem
     */
    public function store(array $attributes): RoleItem
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
