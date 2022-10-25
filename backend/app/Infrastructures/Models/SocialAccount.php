<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class SocialAccount extends BaseModel
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'provider_name',
        'avatar_path',
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
        return $this->belongsTo('App\Infrastructures\Models\User');
    }
}
