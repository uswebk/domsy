<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class Role extends BaseModel
{
    protected $fillable = [
        'company_id',
        'name',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roleItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\RoleItem', 'role_id');
    }

    /**
     * @param string $routeName
     * @return boolean
     */
    public function hasRoleItem(string $routeName): bool
    {
        $roleItems = $this->roleItems;

        foreach ($roleItems as $roleItem) {
            if ($roleItem->menuItem->route === $routeName) {
                return true;
            }
        }

        return false;
    }
}
