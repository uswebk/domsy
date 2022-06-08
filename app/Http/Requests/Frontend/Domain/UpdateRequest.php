<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Domain;

use App\Http\Requests\Request;
use App\Services\Application\InputData\DomainUpdateRequest;

class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'registrar_id' => 'required|integer',
            'name' => 'required|string',
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
