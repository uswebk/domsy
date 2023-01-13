<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Account\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class AccountStoreRequest
{
    private User $user;

    /**
     * @param StoreRequest $storeRequest
     */
    public function __construct(StoreRequest $storeRequest)
    {
        $validated = $storeRequest->validated();

        $validated = array_merge($validated, [
            'password' => Hash::make($storeRequest->password),
            'email_verify_token' => base64_encode($storeRequest->email),
        ]);

        $this->user = new User($validated);
    }

    /**
     * @return User
     */
    public function getInput(): User
    {
        return $this->user;
    }
}
