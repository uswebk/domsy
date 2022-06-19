<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class MenuItem extends BaseModel
{
    protected $fillable = [
        'parent_id',
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
    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Menu', 'parent_id');
    }

    /**
     * @return boolean
     */
    public function isScreen(): bool
    {
        return $this->is_screen;
    }
}
