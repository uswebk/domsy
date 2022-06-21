<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Models\UserMailSetting;

final class UserMailSettingRepository implements UserMailSettingRepositoryInterface
{
    /**
     * @param integer $userId
     * @param integer $mailCategoryId
     * @param boolean $isReceived
     * @param integer $noticeNumberDays
     * @return \App\Infrastructures\Models\UserMailSetting
     */
    public function updateOfUserIdAndMailCategoryIdEqual(
        int $userId,
        int $mailCategoryId,
        bool $isReceived,
        int $noticeNumberDays
    ): \App\Infrastructures\Models\UserMailSetting {
        $userMailSetting = UserMailSetting::firstOrNew([
            'user_id' => $userId,
            'mail_category_id' => $mailCategoryId,
        ]);

        $userMailSetting->is_received = $isReceived;
        $userMailSetting->notice_number_days = $noticeNumberDays;

        $userMailSetting->save();

        return $userMailSetting;
    }
}
