<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Domain;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'registrar_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|integer',
            'is_active' => 'required|boolean',
            'is_transferred' => 'required|boolean',
            'is_management_only' => 'required|boolean',
            'purchased_at' => 'required|date_format:Y-m-d',
            'expired_at' => 'required|date_format:Y-m-d',
            'canceled_at' => 'nullable|date_format:Y-m-d',
        ];
    }
    protected function passedValidation(): void
    {
        $this->merge([
            'registrar_id' => (int) $this->registrar_id,
        ]);
    }
}
