<?php

declare(strict_types=1);

namespace App\Services\Application\DataTransferObjects;

use App\Infrastructures\Models\Eloquent\MailCategory;
use App\Infrastructures\Models\Eloquent\UserMailSetting;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class SettingSaveDto
{
    public $userMailSettings;

    /**
     * @param \App\Http\Requests\Client\Setting\SaveRequest $saveRequest
     */
    public function __construct(
        \App\Http\Requests\Client\Setting\SaveRequest $saveRequest
    ) {
        $this->userMailSettings = new Collection();

        $mailSettingParameter = $saveRequest->request->all();

        $mailCategories = MailCategory::get();

        foreach ($mailCategories as $mailCategory) {
            $parameter = [];

            $parameter = array_merge($mailSettingParameter[$mailCategory->name], [
                'user_id' => Auth::id(),
                'mail_category_id' => $mailCategory->id,
            ]);

            if (! $mailCategory->hasDays()) {
                $parameter = array_merge($parameter, [
                    'notice_number_days' => 0,
                ]);
            }

            $userMailSetting = new UserMailSetting($parameter);

            $this->userMailSettings->push($userMailSetting);
        }
    }
}
