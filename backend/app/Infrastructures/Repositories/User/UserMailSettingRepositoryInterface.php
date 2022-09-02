<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

interface UserMailSettingRepositoryInterface
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
    ): \App\Infrastructures\Models\UserMailSetting;
}
