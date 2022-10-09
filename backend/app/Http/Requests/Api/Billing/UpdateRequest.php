<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Billing;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

final class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'total' => 'required|integer',
            'is_fixed' => 'required|boolean',
            'changed_at' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function makeInput(): array
    {
        return [
            'billing_date' => $this->billing_date,
            'total' => $this->total,
            'is_fixed' => $this->is_fixed,
            'changed_at' => $this->changed_at,
        ];
    }

    public function withValidator(Validator $validator)
    {
        $billing_date = $this->domainBilling->billing_date->format('Y-m-d');

        $validator->sometimes('billing_date', 'required|date_format:Y-m-d|after:yesterday', function ($input) use ($billing_date) {
            return $input->billing_date !== $billing_date;
        });
    }
}
