<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Setting;

use App\Http\Requests\Request;

use App\Services\Application\InputData\SettingSaveRequest;

class SaveRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return \App\Services\Application\InputData\SettingSaveRequest
     */
    public function makeInput(): \App\Services\Application\InputData\SettingSaveRequest
    {
        return new SettingSaveRequest($this);
    }
}
