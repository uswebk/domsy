<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Request;

final class UpdateRequest extends Request
{
    /**
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
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
            'name' => $this->name,
            'email' => $this->email,
            'zip' => $this->zip,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
        ];
    }
}
