<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Models\UserGeneralSetting;

final class UserGeneralSettingRepository implements UserGeneralSettingRepositoryInterface
{
    /**
     * @param integer $userId
     * @param integer $generalId
     * @param boolean $enabled
     * @return \App\Infrastructures\Models\UserGeneralSetting
     */
    public function updateOfUserIdAndGeneralIdEqual(
        int $userId,
        int $generalId,
        bool $enabled,
    ): \App\Infrastructures\Models\UserGeneralSetting {
        $userGeneralSetting = UserGeneralSetting::firstOrNew([
            'user_id' => $userId,
            'general_id' => $generalId,
        ]);

        $userGeneralSetting->enabled = $enabled;
        $userGeneralSetting->save();

        return $userGeneralSetting;
    }
}
