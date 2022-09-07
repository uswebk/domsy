<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Setting;

final class SettingGeneralSaveService
{
    private $userGeneralSettingRepository;

    /**
     * @param \App\Infrastructures\Repositories\User\UserGeneralSettingRepositoryInterface $userGeneralSettingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\User\UserGeneralSettingRepositoryInterface $userGeneralSettingRepository
    ) {
        $this->userGeneralSettingRepository = $userGeneralSettingRepository;
    }

    /**
     * @param \App\Services\Application\InputData\SettingGeneralSaveRequest $settingGeneralSaveRequest
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\SettingGeneralSaveRequest $settingGeneralSaveRequest
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
