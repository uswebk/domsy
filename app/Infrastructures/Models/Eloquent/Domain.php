<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Carbon\Carbon;

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

    protected $dates = [
        'purchased',
        'expired_date',
        'canceled_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_transferred' => 'boolean',
        'is_management_only' => 'boolean',
        'purchased' => 'datetime',
        'expired_date' => 'datetime',
        'canceled_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }

    public function getPurchasedAttribute(string $date): string
    {
        return (new Carbon($date))->format('Y/m/d');
    }

    public function getExpiredDateAttribute(string $date): string
    {
        return (new Carbon($date))->format('Y/m/d');
    }

    public function getCanceledAtAttribute(string $date): string
    {
        return (new Carbon($date))->format('Y/m/d');
    }
}
