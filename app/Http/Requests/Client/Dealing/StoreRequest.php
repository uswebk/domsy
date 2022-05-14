<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dealing;

use App\Http\Requests\Request;

use Illuminate\Support\Carbon;
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
            'billing_date' => 'required|date_format:Y-m-d|after:yesterday',
            'interval' => 'required|integer',
            'interval_category' => 'required|integer',
            'is_auto_update' => 'required|boolean',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'domain_id' => (int) $this->domain_id,
            'client_id' => (int) $this->client_id,
            'subtotal' => (int) $this->subtotal,
            'discount' => (int) $this->discount,
            'billing_date' => new Carbon($this->billing_date),
            'interval' => (int) $this->interval,
            'interval_category' => (int) $this->interval_category,
            'is_auto_update' => (bool) $this->is_auto_update,
            'user_id' => Auth::id(),
        ]);
    }
}