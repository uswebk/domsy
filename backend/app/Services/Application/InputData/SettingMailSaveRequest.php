<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Setting\SaveMailRequest;
use App\Models\MailCategory;
use App\Models\UserMailSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class SettingMailSaveRequest
{
    private Collection $userMailSettings;

    /**
     * @param SaveMailRequest $saveRequest
     */
    public function __construct(SaveMailRequest $saveRequest)
    {
        $this->userMailSettings = new Collection();

        $mailSettingParameter = $saveRequest->request->all();

        $mailCategories = MailCategory::get();

        foreach ($mailCategories as $mailCategory) {
            $parameter = array_merge($mailSettingParameter[$mailCategory->name], [
                'user_id' => Auth::id(),
                'mail_category_id' => $mailCategory->id,
            ]);

            if (!$mailCategory->hasDays()) {
                $parameter = array_merge($parameter, [
                    'notice_number_days' => 0,
                ]);
            }

            $userMailSetting = new UserMailSetting($parameter);

            $this->userMailSettings->push($userMailSetting);
        }
    }

    /**
     * @return Collection
     */
    public function getInput(): Collection
    {
        return $this->userMailSettings;
    }
}
