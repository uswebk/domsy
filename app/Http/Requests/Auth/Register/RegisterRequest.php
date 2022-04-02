<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\Register;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'password' => \Hash::make($this->password),
            'email_verify_token' => base64_encode($this->email),
        ]);
    }
}
