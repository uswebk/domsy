<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

final class AccountStoreRequest
{
    private $user;

    /**
     * @param App\Http\Requests\Api\Account\StoreRequest $storeRequest
     */
    public function __construct(
        \App\Http\Requests\Api\Account\StoreRequest $storeRequest
    ) {
        $validated = $storeRequest->validated();

        $validated = array_merge($validated, [
            'password' => Hash::make($storeRequest->password),
            'email_verify_token' => base64_encode($storeRequest->email),
        ]);

        $this->user = new User($validated);
    }

    /**
     * @return \App\Models\User
     */
    public function getInput(): \App\Models\User
    {
        return $this->user;
    }
}
