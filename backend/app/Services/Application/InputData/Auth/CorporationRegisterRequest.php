<?php

declare(strict_types=1);

namespace App\Services\Application\InputData\Auth;

use App\Models\Company;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

final class CorporationRegisterRequest
{
    private $company;

    private $user;

    /**
     * @param \App\Http\Requests\Auth\Corporation\RegisterRequest $registerRequest
     */
    public function __construct(
        \App\Http\Requests\Auth\Corporation\RegisterRequest $registerRequest
    ) {
        $validated = $registerRequest->validated();

        $this->company = new Company($validated['corporation']);

        $validated['individual']['name'] = $validated['name'];
        $validated['individual']['email'] = $validated['email'];
        $validated['individual']['emoji'] = $validated['emoji'];
        $validated['individual']['password'] = Hash::make($registerRequest['password']);
        $validated['individual']['email_verify_token'] = base64_encode($registerRequest['email']);

        $this->user = new User($validated['individual']);
    }

    /**
     * @return \App\Models\Company
     */
    public function getInputCompany(): \App\Models\Company
    {
        return $this->company;
    }

    /**
     * @return \App\Models\User
     */
    public function getInputUser(): \App\Models\User
    {
        return $this->user;
    }
}
