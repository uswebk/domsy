<?php

declare(strict_types=1);

namespace App\Services\Application\InputData\Auth;

use App\Http\Requests\Auth\RegisterRequest as AuthRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class RegisterRequest
{
    private User $user;

    /**
     * @param AuthRegisterRequest $registerRequest
     */
    public function __construct(AuthRegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();

        $validated = array_merge($validated, [
            'password' => Hash::make($registerRequest->password),
            'email_verify_token' => base64_encode($registerRequest->email),
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
