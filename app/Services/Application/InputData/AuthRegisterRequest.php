<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\User;

use Illuminate\Support\Facades\Hash;

final class AuthRegisterRequest
{
    private $user;

    /**
     * @param \App\Http\Requests\Auth\RegisterRequest $registerRequest
     */
    public function __construct(
        \App\Http\Requests\Auth\RegisterRequest $registerRequest
    ) {
        $validated = $registerRequest->validated();

        $validated = array_merge($validated, [
            'password' => Hash::make($registerRequest->password),
            'email_verify_token' => base64_encode($registerRequest->email),
        ]);

        $this->user = new User($validated);
    }

    /**
     * @return \App\Infrastructures\Models\User
     */
    public function getInput(): \App\Infrastructures\Models\User
    {
        return $this->user;
    }
}
