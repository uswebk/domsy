<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class Registrar extends BaseModel
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
    public function domains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\Domain', 'registrar_id');
    }
}
