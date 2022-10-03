<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class DomainBilling extends BaseModel
{
    protected $fillable = [
        'dealing_id',
        'total',
        'billing_date',
        'is_fixed',
        'is_auto',
        'changed_at',
    ];

    protected $casts = [
        'total' => 'integer',
        'is_fixed' => 'boolean',
        'is_auto' => 'boolean',
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
        return $this->belongsTo('App\Infrastructures\Models\DomainDealing', 'dealing_id');
    }

    /**
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->domainDealing->getUserId();
    }

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domainDealing->getDomainName();
    }

    /**
     * @return boolean
     */
    public function isFixed(): bool
    {
        return $this->is_fixed;
    }
}
