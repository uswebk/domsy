<?php

declare(strict_types=1);

namespace App\Mails\Services;

use App\Mails\Client\EmailVerification;
use App\Models\User;

final class EmailVerificationService
{
    /**
     * @param User $user
     * @return void
     */
    public function execute(User $user): void
    {
        $user->notify(new EmailVerification());
    }
}
