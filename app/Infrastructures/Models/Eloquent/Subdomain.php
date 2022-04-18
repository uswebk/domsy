<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class Subdomain extends BaseModel
{
    protected $fillable = [
        'domain_id',
        'prefix',
        'type_id',
        'value',
        'ttl',
        'priority',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Domain');
    }

    public function dnsRecordType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\DnsRecordType', 'type_id');
    }

    public function getFullDomainNameAttribute(): string
    {
        if (isset($this->prefix)) {
            return $this->prefix . '.' . $this->domain->name;
        }

        return $this->domain->name;
    }

    public function getDnsTypeAttribute(): string
    {
        return (isset($this->dnsRecordType)) ? $this->dnsRecordType->name : '';
    }
}
