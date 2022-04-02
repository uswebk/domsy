<?php

declare(strict_types=1);

namespace App\Services\Application\Auth\Register;

use App\Infrastructures\Repositories\User\UserRepository;

// use App\Repositories\UserLatestCode\UserLatestCodeRepository;

final class RegisterService
{
    private $userRepository;

    private const REGISTRATION_FAILED_MESSAGE = 'ユーザーの登録に失敗しました。再度登録をお願いいたします。';

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(array $input): void
    {
        \DB::beginTransaction();
        try {
            $user = $this->userRepository->store($input);

            $user->sendEmailVerificationNotification();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception(self::REGISTRATION_FAILED_MESSAGE);
        }
    }
}
