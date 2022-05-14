<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMailSetting extends BaseModel
{
    use HasFactory;

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
        'is_received' => 'boolean',
    ];

    public function mailCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\MailCategory');
    }

    public function isDomainExpiration(): bool
    {
        return $this->mailCategory->isDomainExpiration();
    }

    public function isRejection(): bool
    {
        return ! $this->is_received;
    }
}
