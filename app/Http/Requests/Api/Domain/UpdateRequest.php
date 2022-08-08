<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Domain;

use App\Http\Requests\Request;
use App\Rules\DomainNameDuplicate;
use App\Rules\RegistrarOwner;
use App\Services\Application\InputData\DomainUpdateRequest;

final class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'registrar_id' => new RegistrarOwner(),
            'name' => ['min:1',new DomainNameDuplicate($this->domain)],
            'price' => 'required|integer',
            'is_active' => 'required|boolean',
            'is_transferred' => 'required|boolean',
            'is_management_only' => 'required|boolean',
            'purchased_at' => 'required|date_format:Y-m-d',
            'expired_at' => 'required|date_format:Y-m-d',
            'canceled_at' => 'nullable|date_format:Y-m-d',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\DomainUpdateRequest
     */
    public function makeInput(): \App\Services\Application\InputData\DomainUpdateRequest
    {
        return new DomainUpdateRequest($this);
    }
}
