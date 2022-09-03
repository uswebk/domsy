<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class MenuType extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Menu', 'type_id');
    }
}
