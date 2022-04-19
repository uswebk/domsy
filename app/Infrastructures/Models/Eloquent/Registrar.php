<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class Registrar extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'link',
        'note',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }

    public function domainDealing(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\DomainDealing', 'registrar_id');
    }
}
