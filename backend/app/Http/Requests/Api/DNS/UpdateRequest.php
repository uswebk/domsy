<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\DNS;

use App\Http\Requests\Request;
use App\Rules\DnsType;
use App\Rules\DomainOwner;

final class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'prefix' => 'nullable|string',
            'domain_id' => new DomainOwner(),
            'type_id' => new DnsType(),
            'value' => 'nullable|string',
            'ttl' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer|min:0',
        ];
    }

    /**
     * @return array
     */
    public function makeInput(): array
    {
        return [
            'prefix' => $this->prefix ?? '',
            'domain_id' => $this->domain_id,
            'type_id' => $this->type_id ?? 0,
            'value' => $this->value ?? '',
            'ttl' => $this->ttl ?? 0,
            'priority' => $this->priority ?? 0,
        ];
    }
}
