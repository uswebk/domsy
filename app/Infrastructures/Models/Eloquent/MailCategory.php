<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class MailCategory extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort',
    ];
}
