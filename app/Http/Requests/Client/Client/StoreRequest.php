<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Client;

use App\Http\Requests\Request;

use Illuminate\Support\Facades\Auth;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'name_kana' => 'nullable|string',
            'email' => 'required|string|email|max:255',
            'zip' => 'required|string|digits:7',
            'address' => 'required|string',
            'phone_number' => 'required|numeric',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }
}
