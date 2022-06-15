<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class Menu extends BaseModel
{
    protected $fillable = [
        'type_id',
        'name',
        'controller',
        'function',
        'route',
        'description',
        'is_screen',
        'sort',
    ];

    protected $casts = [
        'is_screen' => 'boolean',
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
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\MenuType', 'type_id');
    }

    /**
     * @return boolean
     */
    public function isScreen(): bool
    {
        return $this->is_screen;
    }
}
