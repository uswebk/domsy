<?php

declare(strict_types=1);

namespace App\Services\Application;

final class SettingMailSaveService
{
    private $userMailSettingRepository;

    /**
     * @param \App\Infrastructures\Repositories\User\UserMailSettingRepositoryInterface $userMailSettingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\User\UserMailSettingRepositoryInterface $userMailSettingRepository
    ) {
        $this->userMailSettingRepository = $userMailSettingRepository;
    }

    /**
     * @param \App\Services\Application\InputData\SettingMailSaveRequest $settingMailSaveRequest
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\SettingMailSaveRequest $settingMailSaveRequest
    ): void {
        $userMailSettings = $settingMailSaveRequest->getInput();

        foreach ($userMailSettings as $userMailSetting) {
            $this->userMailSettingRepository->updateOfUserIdAndMailCategoryIdEqual(
                $userMailSetting->user_id,
                $userMailSetting->mail_category_id,
                $userMailSetting->is_received,
                $userMailSetting->notice_number_days,
            );
        }
    }
}
