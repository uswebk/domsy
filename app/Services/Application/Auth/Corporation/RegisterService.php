<?php

declare(strict_types=1);

namespace App\Services\Application\Auth\Corporation;

use App\Constants\RoleConstant;
use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    private $userRepository;

    private $userLatestCodeRepository;

    private $emailVerificationService;

    public function __construct(
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository,
        \App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * @param \App\Services\Application\InputData\AuthCorporationRegisterRequest $registerRequest
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\AuthCorporationRegisterRequest $registerRequest
    ): void {
        $companyRequest = $registerRequest->getInputCompany();

        $userRequest = $registerRequest->getInputUser();

        $code = $this->userLatestCodeRepository->next();

        $user = $this->userRepository->store([
            'name' => $userRequest->name,
            'company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID, // 追加したcompany_idを取得
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
