<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class UserMailSetting extends BaseModel
{
    protected $fillable = [
        'user_id',
        'mail_category_id',
        'notice_number_days',
        'is_received',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'mail_category_id' => 'integer',
        'notice_number_days' => 'integer',
        'is_received' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mailCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\MailCategory');
    }

    /**
     * @return boolean
     */
    public function isDomainExpiration(): bool
    {
        return $this->mailCategory->isDomainExpiration();
    }

    /**
     * @return boolean
     */
    public function isRejection(): bool
    {
        return ! $this->is_received;
    }
}
