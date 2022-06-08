<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Client;

use App\Http\Requests\Request;

use Illuminate\Support\Facades\Auth;

final class StoreRequest extends Request
{
    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function makeInput(): array
    {
        return [
            'user_id' => Auth::id(),
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'email' => $this->email,
            'zip' => $this->zip,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
        ];
    }
}
