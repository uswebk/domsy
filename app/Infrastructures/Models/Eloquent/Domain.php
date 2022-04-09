<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class Domain extends BaseModel
{
    protected $fillable = [
        'name',
        'user_id',
        'price',
        'is_active',
        'is_transferred',
        'is_management_only',
        'purchased',
        'expired_date',
        'canceled_at',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }
}
