<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

interface UserMailSettingRepositoryInterface
{
    public function updateOfUserIdAndMailCategoryIdEqual(
        int $userId,
        int $mailCategoryId,
        bool $isReceived,
        int $noticeNumberDays
    ): \App\Infrastructures\Models\Eloquent\UserMailSetting;
}
