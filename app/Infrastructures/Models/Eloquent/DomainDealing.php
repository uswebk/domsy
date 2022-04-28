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
        'created_at',
        'updated_at',
    ];

    protected const INTERVAL_CATEGORIES = [
        'Day',
        'Week',
        'Month',
        'Year',
    ];

    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Domain', 'domain_id');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Client', 'client_id');
    }

    public static function getIntervalCategories(): array
    {
        return self::INTERVAL_CATEGORIES;
    }
}
