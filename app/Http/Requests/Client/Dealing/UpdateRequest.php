<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dealing;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
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
            'billing_date' => new \Carbon\Carbon($this->billing_date),
            'interval' => (int) $this->interval,
            'interval_category' => (int) $this->interval_category,
            'is_auto_update' => (bool) $this->is_auto_update,
        ]);
    }

    public function withValidator(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $validator->sometimes('domain_id', 'required|integer', function ($input) {
            $domainDealing = $this->route()->parameter('domainDealing');

            return $domainDealing->isUnclaimed();
        });

        $validator->sometimes('client_id', 'required|integer', function ($input) {
            $domainDealing = $this->route()->parameter('domainDealing');

            return $domainDealing->isUnclaimed();
        });

        $validator->sometimes('billing_date', 'required|date_format:Y-m-d|after:yesterday', function ($input) {
            $domainDealing = $this->route()->parameter('domainDealing');

            return $domainDealing->isUnclaimed();
        });

        return $validator;
    }
}
