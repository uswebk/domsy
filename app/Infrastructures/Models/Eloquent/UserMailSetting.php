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
}
