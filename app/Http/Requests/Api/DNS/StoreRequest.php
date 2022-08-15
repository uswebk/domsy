<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\DNS;

use App\Http\Requests\Request;
use App\Rules\DnsType;
use App\Rules\DomainOwner;
use App\Services\Application\InputData\DnsStoreRequest;

final class StoreRequest extends Request
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
     * @return \App\Services\Application\InputData\DnsStoreRequest
     */
    public function makeInput(): \App\Services\Application\InputData\DnsStoreRequest
    {
        return new DnsStoreRequest($this);
    }
}
