<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\Corporation;

use App\Http\Requests\Request;
use App\Services\Application\InputData\AuthCorporationRegisterRequest;

final class RegisterRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
        ];
    }

    /**
     * @return \App\Services\Application\InputData\AuthCorporationRegisterRequest
     */
    public function makeInput(): \App\Services\Application\InputData\AuthCorporationRegisterRequest
    {
        return new AuthCorporationRegisterRequest($this);
    }
}
