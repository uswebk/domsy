<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\GeneralSettingCategory;
use App\Infrastructures\Models\UserGeneralSetting;

use Illuminate\Database\Collection;
use Illuminate\Support\Facades\Auth;

final class SettingGeneralSaveRequest
{
    private $userGeneralSettings;

    public function __construct(
        \App\Http\Requests\Frontend\Setting\SaveGeneralRequest $saveRequest
    ) {
        $this->userGeneralSettings = new Collection();

        $generalSettingParameter = $saveRequest->request->all();
        $generalSettingCategories = GeneralSettingCategory::all();

        foreach ($generalSettingCategories as $generalSettingCategory) {
            $userGeneralSetting = new UserGeneralSetting([
                'user_id' => Auth::id(),
                'general_id' => $generalSettingCategory->id,
                'enabled' => $generalSettingParameter[$generalSettingCategory->name],
            ]);

            $this->userGeneralSettings->push($userGeneralSetting);
        }
    }

    /**
     * @return \Illuminate\Database\Collection
     */
    public function getInput(): \Illuminate\Database\Collection
    {
        return $this->userGeneralSettings;
    }
}
