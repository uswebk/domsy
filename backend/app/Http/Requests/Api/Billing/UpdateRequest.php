<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Billing;

use App\Http\Requests\Request;

final class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'billing_date' => 'required|date_format:Y-m-d|after:yesterday',
            'total' => 'required|integer',
            'is_fixed' => 'required|boolean',
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
        ];
    }
}
