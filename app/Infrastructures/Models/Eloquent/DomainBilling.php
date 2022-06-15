<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class DomainBilling extends BaseModel
{
    protected $fillable = [
        'dealing_id',
        'total',
        'billing_date',
        'is_fixed',
        'changed_at',
    ];

    protected $dates = [
        'billing_date',
        'changed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domainDealing(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\DomainDealing', 'dealing_id');
    }
}
