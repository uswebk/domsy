<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Setting;

use App\Http\Requests\Request;
use App\Services\Application\DataTransferObjects\SettingSaveDto;

class SaveRequest extends Request
{
    public function rules()
    {
        return [];
    }

    /**
     * @return \App\Services\Application\DataTransferObjects\SettingSaveDto
     */
    public function makeDto(): \App\Services\Application\DataTransferObjects\SettingSaveDto
    {
        return new SettingSaveDto($this);
    }
}
