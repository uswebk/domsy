<?php

declare(strict_types=1);

namespace App\Repositories\User;

interface UserMailSettingRepositoryInterface
{
    /**
     * @param integer $userId
     * @param integer $mailCategoryId
     * @param boolean $isReceived
     * @param integer $noticeNumberDays
     * @return \App\Models\UserMailSetting
     */
    public function updateOfUserIdAndMailCategoryIdEqual(
        int $userId,
        int $mailCategoryId,
        bool $isReceived,
        int $noticeNumberDays
    ): \App\Models\UserMailSetting;
}
