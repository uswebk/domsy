<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;
use App\Infrastructures\Queries\User\EloquentUserQueryService;
use App\Infrastructures\Repositories\User\UserRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class EmailVerifyService
{
    private $request;
    private $userRepository;
    private $eloquentUserQueryService;

    public function __construct(
        Request $request,
        UserRepositoryInterface $userRepository,
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

            $user = $this->eloquentUserQueryService->firstByIdEmailVerifyToken(Auth::Id(), $this->request->hash);

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

            \Log::info($e->getMessage());

            throw $e;
        }
    }
}
