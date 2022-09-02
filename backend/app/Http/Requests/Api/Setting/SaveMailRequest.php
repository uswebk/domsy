<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Setting;

use App\Http\Requests\Request;

use App\Services\Application\InputData\SettingMailSaveRequest;

final class SaveMailRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.is_received' => 'boolean',
            '*.notice_number_days' => 'integer|min:0',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\SettingMailSaveRequest
     */
    public function makeInput(): \App\Services\Application\InputData\SettingMailSaveRequest
    {
        return new SettingMailSaveRequest($this);
    }
}
