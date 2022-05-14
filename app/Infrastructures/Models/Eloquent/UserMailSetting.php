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


    protected const MAIL_CATEGORY_DOMAIN_EXPIRATION = 'domain_expiration';

    public function mailCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\MailCategory');
    }

    public function isMatchByMailCategoryName($mailCategoryName): bool
    {
        return $this->mailCategory->name == $mailCategoryName;
    }

    public function isDomainExpiration(): bool
    {
        return $this->isMatchByMailCategoryName(self::MAIL_CATEGORY_DOMAIN_EXPIRATION);
    }

    public function isRejection(): bool
    {
        $a = $this->is_received;
        return ! $this->is_received;
    }
}
