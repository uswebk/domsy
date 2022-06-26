<?php

declare(strict_types=1);

namespace App\Services\Application\InputData\Auth;

use App\Infrastructures\Models\Company;
use App\Infrastructures\Models\User;

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

        $validated['individual']['password'] = Hash::make($registerRequest['individual']['password']);
        $validated['individual']['email_verify_token'] = base64_encode($registerRequest['individual']['email']);

        $this->user = new User($validated['individual']);
    }

    /**
     * @return \App\Infrastructures\Models\Company
     */
    public function getInputCompany(): \App\Infrastructures\Models\Company
    {
        return $this->company;
    }

    /**
     * @return \App\Infrastructures\Models\User
     */
    public function getInputUser(): \App\Infrastructures\Models\User
    {
        return $this->user;
    }
}
