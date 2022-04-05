<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\SendServices;

use App\Infrastructures\Mails\Client\EmailVerification;

final class EmailVerificationService
{
    public function execute(
        \App\Infrastructures\Models\Eloquent\User $user
    ): void {
        $user->notify(new EmailVerification());
    }
}
