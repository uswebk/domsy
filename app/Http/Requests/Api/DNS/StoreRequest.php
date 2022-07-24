<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\DNS;

use App\Http\Requests\Request;
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
            'type_id' => 'required|integer', // TODO:: バリデーション
            'value' => 'nullable|string',
            'ttl' => 'nullable|integer',
            'priority' => 'nullable|integer',
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
