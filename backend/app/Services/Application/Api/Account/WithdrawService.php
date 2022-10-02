<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Account;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class WithdrawService
{
    private $userRepository;

    private $user;

    /**
     * @param \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->user = Auth::user();
    }

    /**
     * @param \App\Services\Application\InputData\AccountStoreRequest $storeRequest
     * @return void
     */
    public function handle(): void
    {
        Auth::guard('web')->logout();

        DB::beginTransaction();
        try {
            $this->userRepository->delete($this->user);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Failed withdraw');
        }
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [];
    }
}
