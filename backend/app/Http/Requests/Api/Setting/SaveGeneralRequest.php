<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Setting;

use App\Http\Requests\Request;
use App\Services\Application\InputData\SettingGeneralSaveRequest;

final class SaveGeneralRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.enabled' => 'boolean',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\SettingGeneralSaveRequest
     */
    public function makeInput(): \App\Services\Application\InputData\SettingGeneralSaveRequest
    {
        return new SettingGeneralSaveRequest($this);
    }
}
