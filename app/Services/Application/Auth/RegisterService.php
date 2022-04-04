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

    private const REGISTRATION_FAILED_MESSAGE = 'Failed Registration';

    public function __construct(
        UserRepository $userRepository,
        UserLatestCodeRepository $userLatestCodeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
    }

    public function handle(array $input): void
    {
        \DB::beginTransaction();
        try {
            $input['code'] = $this->userLatestCodeRepository->next();

            $user = $this->userRepository->store($input);

            $user->sendEmailVerificationNotification();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception(self::REGISTRATION_FAILED_MESSAGE);
        }

        Auth::login($user);
    }
}
