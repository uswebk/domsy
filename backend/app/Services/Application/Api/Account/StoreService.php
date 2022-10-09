<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Account;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private $userRepository;

    private $userLatestCodeRepository;

    private $emailVerificationService;

    private $user;

    /**
     * @param \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
     * @param \App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository
     * @param \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
     */
    public function __construct(
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository,
        \App\Infrastructures\Repositories\User\UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->emailVerificationService = $emailVerificationService;

        $this->user = Auth::user();
    }

    /**
     * @param \App\Services\Application\InputData\AccountStoreRequest $storeRequest
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\AccountStoreRequest $storeRequest
    ): void {
        $userRequest = $storeRequest->getInput();

        DB::beginTransaction();
        try {
            $code = $this->userLatestCodeRepository->next();
            $this->user = $this->userRepository->store([
                'name' => $userRequest->name,
                'company_id' => $this->user->company_id,
                'role_id' => $userRequest->role_id,
                'code' => $code,
                'email' => $userRequest->email,
                'emoji' => $userRequest->emoji,
                'password' => $userRequest->password,
                'email_verify_token' => $userRequest->email_verify_token,
            ]);

            $this->emailVerificationService->execute($this->user);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Failed registration');
        }
    }

    /**
     * @return \App\Http\Resources\UserResource
     */
    public function getResponse(): \App\Http\Resources\UserResource
    {
        return new UserResource($this->user);
    }
}
