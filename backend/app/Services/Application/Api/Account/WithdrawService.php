<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Account;

use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class WithdrawService
{
    private UserRepositoryInterface $userRepository;

    private ?Authenticatable $user;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->user = Auth::user();
    }

    /**
     * @return void
     * @throws Exception
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
