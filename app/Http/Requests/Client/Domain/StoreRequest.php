<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Domain;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'price' => 'required|integer',
            'is_active' => 'required|boolean',
            'is_transferred' => 'required|boolean',
            'is_management_only' => 'required|boolean',
            'purchased' => 'required|date_format:Y-m-d',
            'expired_date' => 'required|date_format:Y-m-d',
            'canceled_at' => 'nullable|date_format:Y-m-d',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }
}
