<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class UserGeneralSetting extends BaseModel
{
    protected $fillable = [
        'user_id',
        'general_id',
        'enabled',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'general_id' => 'integer',
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'updated_at' => 'integer',
        'created_at' => 'integer',
    ];
}
