<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class DnsRecordType extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subdomain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Subdomain', 'type_id');
    }
}
