<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RegisterService
{
    private $userRepository;

    private $userLatestCodeRepository;

    private $emailVerificationService;

    /**
     * @param \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
     * @param \App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository
     * @param \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
     */
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
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $emailVerifyToken
     * @return void
     */
    public function handle(
        string $name,
        string $email,
        string $password,
        string $emailVerifyToken,
    ): void {
        DB::beginTransaction();
        try {
            $code = $this->userLatestCodeRepository->next();

            $user = $this->userRepository->store([
                'name' => $name,
                'code' => $code,
                'email' => $email,
                'password' => $password,
                'email_verify_token' => $emailVerifyToken,
            ]);

            $this->emailVerificationService->execute($user);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            Log::info($e->getMessage());

            throw new Exception('Failed registration');
        }

        Auth::login($user);
    }
}
