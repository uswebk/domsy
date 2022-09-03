<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class Subdomain extends BaseModel
{
    protected $fillable = [
        'domain_id',
        'prefix',
        'type_id',
        'value',
        'ttl',
        'priority',
    ];

    protected $casts = [
        'domain_id' => 'integer',
        'prefix' => 'string',
        'type_id' => 'integer',
        'value' => 'string',
        'ttl' => 'integer',
        'priority' => 'integer',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Domain');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dnsRecordType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\DnsRecordType', 'type_id');
    }

    /**
     * @return string
     */
    public function getFullDomainName(): string
    {
        if ($this->prefix !== '') {
            return $this->prefix . '.' . $this->domain->name;
        }

        return $this->domain->name;
    }

    /**
     * @return string
     */
    public function getDnsTypeAttribute(): string
    {
        return (isset($this->dnsRecordType)) ? $this->dnsRecordType->name : '';
    }
}
