<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Setting\SaveGeneralRequest;
use App\Models\GeneralSettingCategory;
use App\Models\UserGeneralSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class SettingGeneralSaveRequest
{
    private Collection $userGeneralSettings;

    /**
     * @param SaveGeneralRequest $saveRequest
     */
    public function __construct(SaveGeneralRequest $saveRequest)
    {
        $this->userGeneralSettings = new Collection();

        $generalSettingParameter = $saveRequest->request->all();
        $generalSettingCategories = GeneralSettingCategory::all();

        foreach ($generalSettingCategories as $generalSettingCategory) {
            $userGeneralSetting = new UserGeneralSetting([
                'user_id' => Auth::id(),
                'general_id' => $generalSettingCategory->id,
                'enabled' => $generalSettingParameter[$generalSettingCategory->name]['enabled'],
            ]);

            $this->userGeneralSettings->push($userGeneralSetting);
        }
    }

    /**
     * @return Collection
     */
    public function getInput(): Collection
    {
        return $this->userGeneralSettings;
    }
}
