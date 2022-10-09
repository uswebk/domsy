<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Account;

use App\Http\Requests\Request;
use App\Rules\RoleOwner;
use App\Services\Application\InputData\AccountStoreRequest;

final class StoreRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'emoji' => 'required|string',
            'role_id' => new RoleOwner(),
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\AccountStoreRequest
     */
    public function makeInput(): \App\Services\Application\InputData\AccountStoreRequest
    {
        return new AccountStoreRequest($this);
    }
}
