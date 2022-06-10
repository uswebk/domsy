<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use App\Services\Application\InputData\AuthRegisterRequest;

final class RegisterRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\AuthRegisterRequest
     */
    public function makeInput(): \App\Services\Application\InputData\AuthRegisterRequest
    {
        return new AuthRegisterRequest($this);
    }
}
