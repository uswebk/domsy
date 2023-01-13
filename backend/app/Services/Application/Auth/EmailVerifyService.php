<?php

declare(strict_types=1);

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;
use App\Queries\User\UserQueryServiceInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EmailVerifyService
{
    private Request $request;

    private UserRepositoryInterface $userRepository;

    private UserQueryServiceInterface $userQueryService;

    /**
     * @param Request $request
     * @param UserRepositoryInterface $userRepository
     * @param UserQueryServiceInterface $userQueryService
     */
    public function __construct(
        Request $request,
        UserRepositoryInterface $userRepository,
        UserQueryServiceInterface $userQueryService,
    ) {
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->userQueryService = $userQueryService;
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
     * @return void
     * @throws AlreadyVerifiedException|Exception
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {
            if (!$this->isEqualUserIdHash()) {
                throw new Exception();
            }

            $user = $this->userQueryService->firstByIdEmailVerifyToken(Auth::Id(), $this->request->hash);

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
