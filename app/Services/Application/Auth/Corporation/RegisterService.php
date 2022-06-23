<?php

declare(strict_types=1);

namespace App\Services\Application\Auth\Corporation;

use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    public function __construct(
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository,
        \App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
    ) {
    }

    /**
     * @param \App\Services\Application\InputData\AuthCorporationRegisterRequest $registerRequest
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\AuthCorporationRegisterRequest $registerRequest
    ): void {
        // Company 登録

        $companyRequest = $registerRequest->getInputCompany();
        // Repository


        // ユーザー登録
        $code = $this->userLatestCodeRepository->next();

        $userRequest = $registerRequest->getInputUser();
        $user = $this->userRepository->store([
            'name' => $userRequest->name,
            'company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID,
            'role_id' => RoleConstant::DEFAULT_ROLE_ID,
            'code' => $code,
            'email' => $userRequest->email,
            'password' => $userRequest->password,
            'email_verify_token' => $userRequest->email_verify_token,
        ]);

        $this->emailVerificationService->execute($user);

        Auth::login($user);
    }
}
