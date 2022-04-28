<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dns;

use App\Http\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'prefix' => 'nullable|string',
            'domain_id' => 'required|integer',
            'type_id' => 'required|integer',
            'value' => 'nullable|string',
            'ttl' => 'nullable|integer',
            'priority' => 'nullable|integer',
        ];
    }
    protected function passedValidation(): void
    {
        $this->merge([
            'domain_id' => (int) $this->domain_id,
        ]);
    }
}
