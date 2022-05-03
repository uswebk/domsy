<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dealing;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'domain_id' => 'required|integer',
            'client_id' => 'required|integer',
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
            'billing_date' => 'required|date_format:Y-m-d',
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
        ]);
    }
}
