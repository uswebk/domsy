<?php

declare(strict_types=1);

namespace App\Infrastructures\Eloquent\Models;

use App\Infrastructures\Eloquent\EloquentModel;

class UserLatestCode extends EloquentModel
{
    protected $table = 'user_latest_code';

    protected $primaryKey = 'code';

    public $timestamps = false;

    protected $fillable = [
        'code',
    ];
}
