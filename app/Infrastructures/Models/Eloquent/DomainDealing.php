<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DomainDealing extends BaseModel
{
    use HasFactory;

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
}
