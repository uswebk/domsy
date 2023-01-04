<?php

declare(strict_types=1);

namespace App\Models;

final class Client extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'zip',
        'address',
        'phone_number',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainDealings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\DomainDealing', 'client_id');
    }
}
