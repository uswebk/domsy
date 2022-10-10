<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\Corporation;

use App\Http\Requests\Request;
use App\Services\Application\InputData\Auth\CorporationRegisterRequest;

final class RegisterRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'corporation.name' => 'required|string',
            'corporation.email' => 'required|string|email|max:255',
            'corporation.zip' => 'required|string|digits:7',
            'corporation.address' => 'required|string',
            'corporation.phone_number' => 'required|numeric',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'emoji' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\Auth\CorporationRegisterRequest
     */
    public function makeInput(): \App\Services\Application\InputData\Auth\CorporationRegisterRequest
    {
        return new CorporationRegisterRequest($this);
    }
}
