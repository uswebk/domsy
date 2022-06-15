<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

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
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\Subdomain', 'type_id');
    }
}
