<?php

declare(strict_types=1);

namespace App\Services\Application\Auth\Corporation;

use App\Constants\RoleConstant;
use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    private $userRepository;

    private $userLatestCodeRepository;

    private $companyRepository;

    private $emailVerificationService;

    /**
     * @param \App\Repositories\User\UserRepositoryInterface $userRepository
     * @param \App\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository
     * @param \App\Repositories\Company\CompanyRepositoryInterface $companyRepository
     * @param \App\Mails\Services\EmailVerificationService $emailVerificationService
     */
    public function __construct(
        \App\Repositories\User\UserRepositoryInterface $userRepository,
        \App\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        \App\Repositories\Company\CompanyRepositoryInterface $companyRepository,
        \App\Mails\Services\EmailVerificationService $emailVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * @param \App\Services\Application\InputData\Auth\CorporationRegisterRequest $registerRequest
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\Auth\CorporationRegisterRequest $registerRequest
    ): void {
        $companyRequest = $registerRequest->getInputCompany();

        $company = $this->companyRepository->store([
            'name' => $companyRequest->name,
            'email' => $companyRequest->email,
            'zip' => $companyRequest->zip,
            'address' => $companyRequest->address,
            'phone_number' => $companyRequest->phone_number,
        ]);

        $userRequest = $registerRequest->getInputUser();

        $code = $this->userLatestCodeRepository->next();

        $user = $this->userRepository->store([
            'name' => $userRequest->name,
            'company_id' => $company->id,
            'role_id' => RoleConstant::DEFAULT_ROLE_ID,
            'code' => $code,
            'email' => $userRequest->email,
            'emoji' => $userRequest->emoji,
            'password' => $userRequest->password,
            'email_verify_token' => $userRequest->email_verify_token,
        ]);

        $this->emailVerificationService->execute($user);

        Auth::login($user);
    }
}
