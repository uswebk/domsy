<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Setting;

use App\Http\Requests\Request;

use App\Services\Application\InputData\SettingMailSaveRequest;

final class SaveMailRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return \App\Services\Application\InputData\SettingMailSaveRequest
     */
    public function makeInput(): \App\Services\Application\InputData\SettingMailSaveRequest
    {
        return new SettingMailSaveRequest($this);
    }
}
