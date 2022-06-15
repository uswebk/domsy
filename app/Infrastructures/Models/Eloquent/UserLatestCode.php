<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class UserLatestCode extends BaseModel
{
    protected $table = 'user_latest_code';

    protected $primaryKey = 'code';

    public $timestamps = false;

    protected $fillable = [
        'code',
    ];
}
