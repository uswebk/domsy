<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;
use App\Infrastructures\Queries\User\EloquentUserQueryService;
use App\Infrastructures\Repositories\User\UserRepository;
use Illuminate\Http\Request;

final class EmailVerifyService
{
    private $request;
    private $userRepository;
    private $eloquentUserQueryService;

    public function __construct(
        Request $request,
        UserRepository $userRepository,
        EloquentUserQueryService $eloquentUserQueryService,
    ) {
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->eloquentUserQueryService = $eloquentUserQueryService;
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
        \DB::beginTransaction();
        try {
            if (! $this->isEqualUserIdHash()) {
                throw new Exception();
            }

            $user = $this->eloquentUserQueryService
            ->firstOrFailByEmailVerifyTokenUserId($this->request->hash, $this->request->user()->id);

            if (isset($user->email_verified_at)) {
                throw new AlreadyVerifiedException();
            }

            $user->email_verified_at = now();
            $this->userRepository->save($user);

            \DB::commit();
        } catch (AlreadyVerifiedException $e) {
            throw $e;
        } catch (\Exception $e) {
            \DB::rollBack();

            throw $e;
            throw new \Exception('Email verified failed');
        }
    }
}
