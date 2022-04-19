<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class Client extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'name_kana',
        'email',
        'zip',
        'address',
        'phone_number',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }

    public function domainDealings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\DomainDealing', 'client_id');
    }
}
