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
        'purchased_at',
        'expired_at',
        'canceled_at',
    ];

    protected $dates = [
        'purchased_at',
        'expired_at',
        'canceled_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_transferred' => 'boolean',
        'is_management_only' => 'boolean',
        'purchased_at' => 'datetime',
        'expired_at' => 'datetime',
        'canceled_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }

    public function domainDnsRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\DomainDnsRecord');
    }
}
