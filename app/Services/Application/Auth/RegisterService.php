<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Infrastructures\Mails\SendServices\EmailVerificationService;
use App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface;
use App\Infrastructures\Repositories\User\UserRepositoryInterface;

use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    private $userRepository;
    private $userLatestCodeRepository;
    private $emailVerificationService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        EmailVerificationService $emailVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->emailVerificationService = $emailVerificationService;
    }

    public function handle(
        string $name,
        string $email,
        string $password,
        string $email_verify_token,
    ): void {
        \DB::beginTransaction();
        try {
            $code = $this->userLatestCodeRepository->next();

            $user = $this->userRepository->store([
                'name' => $name,
                'code' => $code,
                'email' => $email,
                'password' => $password,
                'email_verify_token' => $email_verify_token,
            ]);

            $this->emailVerificationService->execute($user);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            \Log::info($e->getMessage());

            throw new \Exception('Failed registration');
        }

        Auth::login($user);
    }
}
