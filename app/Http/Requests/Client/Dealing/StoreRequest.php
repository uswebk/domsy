<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dealing;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'domain_id' => 'required|integer',
            'client_id' => 'required|integer',
            'subtotal' => 'required|integer',
            'discount' => 'nullable|integer',
            'billing_date' => 'required|date_format:Y-m-d',
            'interval' => 'nullable|integer',
            'interval_category' => 'nullable|integer',
            'is_auto_update' => 'required|boolean',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'domain_id' => (int) $this->domain_id,
            'client_id' => (int) $this->client_id,
            'user_id' => Auth::id(),
        ]);
    }
}
