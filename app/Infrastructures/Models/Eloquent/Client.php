<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends BaseModel
{
    use HasFactory;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainDealings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\DomainDealing', 'client_id');
    }
}
