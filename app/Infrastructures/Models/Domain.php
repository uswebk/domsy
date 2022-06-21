<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class Domain extends BaseModel
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
        'registrar_id' => 'integer',
        'user_id' => 'integer',
        'is_active' => 'boolean',
        'is_transferred' => 'boolean',
        'is_management_only' => 'boolean',
        'purchased_at' => 'datetime',
        'expired_at' => 'datetime',
        'canceled_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subdomains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Subdomain');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function registrar(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Registrar', 'registrar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainDealings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\DomainDealing', 'domain_id');
    }

    /**
     * @param \Carbon\Carbon $targetDatetime
     * @return boolean
     */
    public function isExpirationDateByTargetDate(
        \Carbon\Carbon $targetDate
    ): bool {
        $targetStartDate = $targetDate->copy()->startOfDay();
        $expirationStartDate = $this->expired_at->copy()->startOfDay();

        return $expirationStartDate->eq($targetStartDate);
    }

    /**
     * @return boolean
     */
    public function isOwned(): bool
    {
        return $this->is_active && ! $this->is_transferred;
    }
}
