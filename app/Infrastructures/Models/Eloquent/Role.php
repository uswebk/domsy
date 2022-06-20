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
}
