<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMailSetting extends BaseModel
{
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

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

    protected const DEFAULT_NOTICE_NUMBER_DAYS = 90;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mailCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\MailCategory');
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

    /**
     * @return integer
     */
    public static function getDefaultNoticeNumberDays(): int
    {
        return self::DEFAULT_NOTICE_NUMBER_DAYS;
    }
}
