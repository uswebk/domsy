<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\ExpiredAuthenticationException;
use App\Infrastructures\Queries\User\EloquentUserQueryService;
use App\Infrastructures\Repositories\User\UserRepository;

final class EmailVerifyService
{
    private $userRepository;
    private $eloquentUserQueryService;

    private const EMAIL_VERIFIED_FAILED_MESSAGE = 'Email Verified Failed';

    public function __construct(
        UserRepository $userRepository,
        EloquentUserQueryService $eloquentUserQueryService,
    ) {
        $this->userRepository = $userRepository;
        $this->eloquentUserQueryService = $eloquentUserQueryService;
    }

    // private function isExpired(): bool
    // {
    //     return true;
    // }

    public function handle(string $emailVerifyToken): void
    {
        try {
            $user = $this->eloquentUserQueryService->firstOrFailByEmailVerifyToken($emailVerifyToken);

            // if ($this->isExpired()) {
            //     throw new ExpiredAuthenticationException();
            // }

            $user->email_verified_at = now();
            $this->userRepository->save($user);
        } catch (ExpiredAuthenticationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(self::EMAIL_VERIFIED_FAILED_MESSAGE);
        }
    }
}
