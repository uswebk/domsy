<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Role', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuItem(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\MenuItem', 'menu_item_id');
    }
}
