<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dns;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'subdomain' => 'nullable|string',
            'type_id' => 'required|integer',
            'value' => 'nullable|string',
            'ttl' => 'nullable|integer',
            'priority' => 'nullable|integer',
        ];
    }
}
