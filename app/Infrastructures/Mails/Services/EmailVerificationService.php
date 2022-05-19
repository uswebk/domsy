<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\Services;

use App\Infrastructures\Mails\Client\EmailVerification;

final class EmailVerificationService
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\User $user
     * @return void
     */
    public function execute(
        \App\Infrastructures\Models\Eloquent\User $user
    ): void {
        $user->notify(new EmailVerification());
    }
}
