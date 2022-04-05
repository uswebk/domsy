<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Infrastructures\Repositories\User\UserRepository;
use App\Infrastructures\Repositories\UserLatestCode\UserLatestCodeRepository;
use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    private $userRepository;
    private $userLatestCodeRepository;

    public function __construct(
        UserRepository $userRepository,
        UserLatestCodeRepository $userLatestCodeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
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

            $user = $this->userRepository->store(
                $name,
                $code,
                $email,
                $password,
                $email_verify_token
            );
            $user->sendEmailVerificationNotification();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            \Log::info($e->getMessage());

            throw new \Exception('Failed registration');
        }

        Auth::login($user);
    }
}
