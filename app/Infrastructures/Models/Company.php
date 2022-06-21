<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class Company extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'zip',
        'address',
        'phone_number',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];
}
