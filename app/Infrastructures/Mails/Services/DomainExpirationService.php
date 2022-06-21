<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\Services;

use App\Infrastructures\Mails\Client\DomainExpiration;

final class DomainExpirationService
{
    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \Illuminate\Database\Collection $domains
     * @param integer $domainNoticeNumberDays
     * @return void
     */
    public function execute(
        \App\Infrastructures\Models\User $user,
        \Illuminate\Database\Collection $domains,
        int $domainNoticeNumberDays
    ): void {
        $user->notify(new DomainExpiration($domains, $domainNoticeNumberDays));
    }
}
