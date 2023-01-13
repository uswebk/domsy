<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Setting;

use App\Repositories\User\UserGeneralSettingRepositoryInterface;
use App\Services\Application\InputData\SettingGeneralSaveRequest;

final class GeneralSaveService
{
    private UserGeneralSettingRepositoryInterface $userGeneralSettingRepository;

    /**
     * @param UserGeneralSettingRepositoryInterface $userGeneralSettingRepository
     */
    public function __construct(UserGeneralSettingRepositoryInterface $userGeneralSettingRepository)
    {
        $this->userGeneralSettingRepository = $userGeneralSettingRepository;
    }

    /**
     * @param SettingGeneralSaveRequest $settingGeneralSaveRequest
     * @return void
     */
    public function handle(
        SettingGeneralSaveRequest $settingGeneralSaveRequest
    ): void {
        $userGeneralSettings = $settingGeneralSaveRequest->getInput();

        foreach ($userGeneralSettings as $userGeneralSetting) {
            $this->userGeneralSettingRepository->updateOfUserIdAndGeneralIdEqual(
                $userGeneralSetting->user_id,
                $userGeneralSetting->general_id,
                $userGeneralSetting->enabled,
            );
        }
    }
}
