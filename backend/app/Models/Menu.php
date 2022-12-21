<?php

declare(strict_types=1);

namespace App\Models;

final class Menu extends BaseModel
{
    protected $fillable = [
        'type_id',
        'name',
        'is_nav',
        'sort',
    ];

    protected $casts = [
        'is_nav' => 'boolean',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\MenuType', 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\MenuItem', 'parent_id');
    }

    /**
     * @return boolean
     */
    public function isNav(): bool
    {
        return $this->is_nav;
    }
}
