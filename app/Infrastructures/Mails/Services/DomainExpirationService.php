<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\Services;

use App\Infrastructures\Mails\Client\DomainExpiration;

final class DomainExpirationService
{
    public function execute(
        \App\Infrastructures\Models\Eloquent\User $user,
        \Illuminate\Database\Eloquent\Collection $domains,
        int $domainNoticeNumberDays
    ): void {
        $user->notify(new DomainExpiration($domains, $domainNoticeNumberDays));
    }
}
