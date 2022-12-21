<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\UserGeneralSetting;

final class UserGeneralSettingRepository implements UserGeneralSettingRepositoryInterface
{
    /**
     * @param integer $userId
     * @param integer $generalId
     * @param boolean $enabled
     * @return \App\Models\UserGeneralSetting
     */
    public function updateOfUserIdAndGeneralIdEqual(
        int $userId,
        int $generalId,
        bool $enabled,
    ): \App\Models\UserGeneralSetting {
        $userGeneralSetting = UserGeneralSetting::firstOrNew([
            'user_id' => $userId,
            'general_id' => $generalId,
        ]);

        $userGeneralSetting->enabled = $enabled;
        $userGeneralSetting->save();

        return $userGeneralSetting;
    }
}
