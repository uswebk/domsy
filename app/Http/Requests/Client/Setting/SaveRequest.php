<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Setting;

use App\DataTransferObjects\Services\Application\SettingSaveDto;

use App\Http\Requests\Request;

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
     * @return \App\DataTransferObjects\Services\Application\SettingSaveDto
     */
    public function makeDto(): \App\DataTransferObjects\Services\Application\SettingSaveDto
    {
        return new SettingSaveDto($this);
    }
}
