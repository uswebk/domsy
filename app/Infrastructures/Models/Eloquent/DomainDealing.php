<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use App\Enums\Interval;

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
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Domain', 'domain_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Client', 'client_id');
    }

    /**
     * @return boolean
     */
    public function isBilled(): bool
    {
        return $this->billing_date->lt(now());
    }

    /**
     * @return boolean
     */
    public function isUnclaimed(): bool
    {
        return ! $this->isBilled();
    }

    /**
     * @return integer
     */
    public function getBillingAmount(): int
    {
        return $this->subtotal - $this->discount;
    }

    /**
     * @param \Carbon\Carbon $targetDate
     * @return \Carbon\Carbon
     */
    public function getNextBillingDateByTargetDate(
        \Carbon\Carbon $targetDate
    ): \Carbon\Carbon {
        $billingDate = $targetDate->copy()->startOfDay();
        $interval = $this->interval;
        $intervalCategory = $this->interval_category;

        if ($intervalCategory === Interval::DAY->name) {
            return $billingDate->addDays($interval);
        }

        if ($intervalCategory === Interval::WEEK->name) {
            return $billingDate->addWeeks($interval);
        }

        if ($intervalCategory === Interval::MONTH->name) {
            return $billingDate->addMonths($interval);
        }

        if ($intervalCategory === Interval::YEAR->name) {
            return $billingDate->addYears($interval);
        }
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getNextBillingDate(): \Carbon\Carbon
    {
        return $this->getNextBillingDateByTargetDate($this->billing_date);
    }
}
