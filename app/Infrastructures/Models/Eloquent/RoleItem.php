<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class RoleItem extends BaseModel
{
    protected $fillable = [
        'role_id',
        'menu_item_id',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $primaryKey = [
        'role_id',
        'menu_item_id',
    ];

    public $incrementing = false;
}
