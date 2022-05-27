<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Models\Eloquent\MailCategory;
use Illuminate\Support\Facades\Auth;

final class SettingSaveService
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
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function handle(\Illuminate\Http\Request $request): void
    {
        // ToDev: メール事前通知日(user_mail_settings.notice_number_days)も設定できるようにする

        $user = Auth::user();
        $mailCategories = MailCategory::get();

        foreach ($mailCategories as $mailCategory) {
            $isReceived = (bool) $request[$mailCategory->name];

            $this->userMailSettingRepository->updateOfUserIdAndMailCategoryIdEqual(
                $user->id,
                $mailCategory->id,
                $isReceived
            );
        }
    }
}
