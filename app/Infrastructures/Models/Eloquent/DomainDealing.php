<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class DomainDealing extends BaseModel
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
    ];

    protected $dates = [
        'billing_date',
        'created_at',
        'updated_at',
    ];

    protected const INTERVAL_CATEGORIES = [
        'Day',
        'Week',
        'Month',
        'Year',
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
     * @return array
     */
    public static function getIntervalCategories(): array
    {
        return self::INTERVAL_CATEGORIES;
    }

    /**
     * @return string
     */
    public function getIntervalCategoryStringAttribute(): string
    {
        $intervalCategories = $this->getIntervalCategories();

        return $intervalCategories[$this->interval_category];
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
}
