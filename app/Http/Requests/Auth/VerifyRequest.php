<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class VerifyRequest extends Request
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    protected function passedValidation(): void
    {
    }
}
