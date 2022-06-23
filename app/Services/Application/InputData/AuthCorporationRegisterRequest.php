<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

final class AuthCorporationRegisterRequest
{
    private $company;

    private $user;

    /**
     * @param \App\Http\Requests\Auth\Corporation\RegisterRequest $registerRequest
     */
    public function __construct(
        \App\Http\Requests\Auth\Corporation\RegisterRequest $registerRequest
    ) {
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
