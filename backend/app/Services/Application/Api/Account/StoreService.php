<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Account;

use App\Http\Resources\UserResource;
use App\Mails\Services\EmailVerificationService;
use App\Repositories\User\UserLatestCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Application\InputData\AccountStoreRequest;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private UserRepositoryInterface $userRepository;

    private UserLatestCodeRepositoryInterface $userLatestCodeRepository;

    private EmailVerificationService $emailVerificationService;

    private ?Authenticatable $user;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserLatestCodeRepositoryInterface $userLatestCodeRepository
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserLatestCodeRepositoryInterface $userLatestCodeRepository,
        EmailVerificationService $emailVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->userLatestCodeRepository = $userLatestCodeRepository;
        $this->emailVerificationService = $emailVerificationService;

        $this->user = Auth::user();
    }

    /**
     * @param AccountStoreRequest $storeRequest
     * @return void
     * @throws Exception
     */
    public function handle(AccountStoreRequest $storeRequest): void
    {
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
     * @return UserResource
     */
    public function getResponse(): UserResource
    {
        return new UserResource($this->user);
    }
}
