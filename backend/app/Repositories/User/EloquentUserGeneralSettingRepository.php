<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\UserGeneralSetting;

final class EloquentUserGeneralSettingRepository implements UserGeneralSettingRepositoryInterface
{
    /**
     * @param integer $userId
     * @param integer $generalId
     * @param boolean $enabled
     * @return UserGeneralSetting
     */
    public function updateOfUserIdAndGeneralIdEqual(int $userId, int $generalId, bool $enabled): UserGeneralSetting
    {
        $userGeneralSetting = UserGeneralSetting::firstOrNew([
            'user_id' => $userId,
            'general_id' => $generalId,
        ]);

        $userGeneralSetting->enabled = $enabled;
        $userGeneralSetting->save();

        return $userGeneralSetting;
    }
}
