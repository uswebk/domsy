<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class UserGeneralSetting extends BaseModel
{
    protected $fillable = [
        'user_id',
        'general_id',
        'enabled',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'general_id' => 'integer',
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'updated_at' => 'integer',
        'created_at' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function generalSettingCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\GeneralSettingCategory', 'general_id');
    }

    /**
     * @return boolean
     */
    public function isDnsAutoFetch(): bool
    {
        return $this->generalSettingCategory->isDnsAutoFetch();
    }
}
