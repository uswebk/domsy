<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class DomainDealing extends BaseModel
{
    protected $fillable = [
        'domain_id',
        'registrar_id',
        'client_id',
        'subtotal',
        'discount',
        'billing_date',
        'interval',
        'interval_category',
        'is_auto_update',
        'is_halt',
    ];

    protected $casts = [
        'domain_id' => 'integer',
        'registrar_id' => 'integer',
        'client_id' => 'integer',
        'subtotal' => 'integer',
        'discount' => 'integer',
        'billing_date' => 'datetime',
        'interval' => 'integer',
        'interval_category' => 'string',
        'is_auto_update' => 'boolean',
        'is_halt' => 'boolean',
    ];

    protected $dates = [
        'billing_date',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Domain', 'domain_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Client', 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainBillings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\DomainBilling', 'dealing_id');
    }

    /**
     * @return boolean
     */
    public function isUnclaimed(): bool
    {
        return $this->billing_date->gte(now());
    }

    /**
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->domain->user_id;
    }

    /**
     * @return integer
     */
    public function getBillingAmount(): int
    {
        return $this->subtotal - $this->discount;
    }

    /**
     * @return \App\Infrastructures\Models\DomainBilling
     */
    public function getNextBilling(): \App\Infrastructures\Models\DomainBilling
    {
        $domainBilling = $this->domainBillings->where('is_fixed', false)
            ->where('is_auto', true)
            ->sortBy('billing_date')->first();

        if (isset($domainBilling)) {
            return $domainBilling;
        }

        return new DomainBilling();
    }

    /**
     * @return integer
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;

        foreach ($this->domainBillings as $domainBilling) {
            if ($domainBilling->isFixed()) {
                $totalPrice += $domainBilling->total;
            }
        }

        return $totalPrice;
    }

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domain->name;
    }

    /**
     * @return boolean
     */
    public function hasFixedBilling(): bool
    {
        foreach ($this->domainBillings as $domainBilling) {
            if ($domainBilling->isFixed()) {
                return true;
            }
        }

        return false;
    }
}
