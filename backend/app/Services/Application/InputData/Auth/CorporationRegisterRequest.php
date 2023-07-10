<?php

declare(strict_types=1);

namespace App\Services\Application\InputData\Auth;

use App\Http\Requests\Auth\Corporation\RegisterRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class CorporationRegisterRequest
{
    private Company $company;

    private User $user;

    /**
     * @param RegisterRequest $registerRequest
     */
    public function __construct(RegisterRequest $registerRequest)
    {
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
     * @return Company
     */
    public function getInputCompany(): Company
    {
        return $this->company;
    }

    /**
     * @return User
     */
    public function getInputUser(): User
    {
        return $this->user;
    }
}
