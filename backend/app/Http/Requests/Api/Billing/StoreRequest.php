<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Billing;

use App\Http\Requests\Request;

final class StoreRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'dealing_id' => 'required|integer',
            'billing_date' => 'required',
            'total' => 'required|integer',
            'is_fixed' => 'required|boolean',
            'is_auto' => 'required|boolean',
        ];
    }

    /**
     * @return array
     */
    public function makeInput(): array
    {
        return [
            'dealing_id' => $this->dealing_id,
            'billing_date' => $this->billing_date,
            'total' => $this->total,
            'is_fixed' => $this->is_fixed,
            'is_auto' => $this->is_auto,
        ];
    }
}
