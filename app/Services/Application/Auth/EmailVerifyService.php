<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\ExpiredAuthenticationException;
use App\Infrastructures\Queries\User\EloquentUserQueryService;
use App\Infrastructures\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

final class EmailVerifyService
{
    private $request;
    private $userRepository;
    private $eloquentUserQueryService;

    private const EMAIL_VERIFIED_FAILED_MESSAGE = 'Email Verified Failed';

    public function __construct(
        Request $request,
        UserRepository $userRepository,
        EloquentUserQueryService $eloquentUserQueryService,
    ) {
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->eloquentUserQueryService = $eloquentUserQueryService;
    }

    private function isExpired(): bool
    {
        return (new Carbon())->gt((new Carbon())
        ->createFromTimestamp($this->request->expires));
    }

    private function isEqualUserIdHash(): bool
    {
        return hash_equals(
            (string) $this->request->route('id'),
            (string) $this->request->user()->getKey()
        );
    }

    public function handle(): void
    {
        try {
            if ($this->isExpired()) {
                throw new ExpiredAuthenticationException();
            }

            if (! $this->isEqualUserIdHash()) {
                throw new Exception();
            }

            $user = $this->eloquentUserQueryService->firstOrFailByEmailVerifyToken($this->request->hash);
            $user->email_verified_at = now();
            $this->userRepository->save($user);
        } catch (ExpiredAuthenticationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(self::EMAIL_VERIFIED_FAILED_MESSAGE);
        }
    }
}
