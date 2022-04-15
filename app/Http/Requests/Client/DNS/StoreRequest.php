<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dns;

use App\Http\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'subdomain' => 'nullable|string',
            'domain_id' => 'required|integer',
            'type_id' => 'required|integer',
            'value' => 'nullable|string',
            'ttl' => 'nullable|integer',
            'priority' => 'nullable|integer',
        ];
    }
}
