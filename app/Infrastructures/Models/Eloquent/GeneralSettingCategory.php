<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class GeneralSettingCategory extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'annotation',
        'sort',
    ];

    protected $casts = [
        'name' => 'string',
        'annotation' => 'string',
        'sort' => 'integer',
    ];
}
