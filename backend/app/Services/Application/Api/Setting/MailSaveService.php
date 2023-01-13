<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Setting;

use App\Repositories\User\UserMailSettingRepositoryInterface;
use App\Services\Application\InputData\SettingMailSaveRequest;

final class MailSaveService
{
    private UserMailSettingRepositoryInterface $userMailSettingRepository;

    /**
     * @param UserMailSettingRepositoryInterface $userMailSettingRepository
     */
    public function __construct(UserMailSettingRepositoryInterface $userMailSettingRepository)
    {
        $this->userMailSettingRepository = $userMailSettingRepository;
    }

    /**
     * @param SettingMailSaveRequest $settingMailSaveRequest
     * @return void
     */
    public function handle(SettingMailSaveRequest $settingMailSaveRequest): void
    {
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
