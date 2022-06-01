<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class EmailVerifyService
{
    private $request;

    private $userRepository;

    private $eloquentUserQueryService;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
     * @param \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository,
        \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService,
    ) {
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->eloquentUserQueryService = $eloquentUserQueryService;
    }

    /**
     * @return boolean
     */
    private function isEqualUserIdHash(): bool
    {
        return hash_equals(
            (string) $this->request->route('id'),
            (string) $this->request->user()->getKey()
        );
    }

    /**
     *
     * @throws AlreadyVerifiedException
     *
     * @return void
     */
    public function handle(): void
    {
        DB::beginTransaction();
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

            DB::commit();
        } catch (AlreadyVerifiedException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
