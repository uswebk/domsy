<?php

declare(strict_types=1);

namespace App\Services\Application\Auth\Corporation;

use App\Constants\RoleConstant;
use App\Mails\Services\EmailVerificationService;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\User\UserLatestCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Application\InputData\Auth\CorporationRegisterRequest;
use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    private UserRepositoryInterface $userRepository;

    private UserLatestCodeRepositoryInterface $userLatestCodeRepository;

    private CompanyRepositoryInterface $companyRepository;

    private EmailVerificationService $emailVerificationService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserLatestCodeRepositoryInterface $userLatestCodeRepository
     * @param CompanyRepositoryInterface $companyRepository
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        CompanyRepositoryInterface $companyRepository,
        EmailVerificationService $emailVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * @param CorporationRegisterRequest $registerRequest
     * @return void
     */
    public function handle(CorporationRegisterRequest $registerRequest): void
    {
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
