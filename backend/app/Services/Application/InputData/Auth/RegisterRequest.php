<?php

declare(strict_types=1);

namespace App\Services\Application\InputData\Auth;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

final class RegisterRequest
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
     * @return \App\Models\User
     */
    public function getInput(): \App\Models\User
    {
        return $this->user;
    }
}
