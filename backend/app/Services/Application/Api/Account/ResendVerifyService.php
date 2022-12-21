<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Account;

use App\Mails\Services\EmailVerificationService;
use App\Models\User;

final class ResendVerifyService
{
    private $emailVerificationService;

    /**
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(
        EmailVerificationService $emailVerificationService
    ) {
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * @param User $user
     * @return void
     */
    public function send(User $user): void
    {
        $this->emailVerificationService->execute($user);
    }
}
