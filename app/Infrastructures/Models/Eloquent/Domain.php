<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class Domain extends BaseModel
{
    protected $fillable = [
        'name',
        'registrar_id',
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

    public function subdomain(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\Subdomain');
    }

    public function registrar(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Registrar', 'registrar_id');
    }

    public function domainDealings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\DomainDealing', 'domain_id');
    }

    public function isExpirationDateByTargetDate(\Illuminate\Support\Carbon $_targetDate): bool
    {
        $targetDate = $_targetDate->copy()->startOfDay();
        $expiredDate = $this->expired_at->copy()->startOfDay();

        return $expiredDate->eq($targetDate);
    }

    public function isOwned():bool
    {
        return $this->is_active && ! $this->is_transferred;
    }
}
