<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class DomainDnsRecord extends BaseModel
{
    protected $fillable = [
        'domain_id',
        'subdomain',
        'dns_type_id',
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

    public function dns_record_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\DnsRecordType', 'type_id');
    }

    public function getFullDomainNameAttribute(): string
    {
        if (isset($this->subdomain)) {
            return $this->subdomain . '.' . $this->domain->name;
        }

        return $this->domain->name;
    }

    public function getDnsTypeAttribute(): string
    {
        return (isset($this->dns_record_type)) ? $this->dns_record_type->name : '';
    }
}
