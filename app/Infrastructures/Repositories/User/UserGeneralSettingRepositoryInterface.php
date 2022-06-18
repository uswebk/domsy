<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

interface UserGeneralSettingRepositoryInterface
{
    /**
     * @param integer $userId
     * @param integer $generalId
     * @param boolean $enabled
     * @return \App\Infrastructures\Models\Eloquent\UserGeneralSetting
     */
    public function updateOfUserIdAndGeneralIdEqual(
        int $userId,
        int $generalId,
        bool $enabled,
    ): \App\Infrastructures\Models\Eloquent\UserGeneralSetting;
}
