<?php

declare(strict_types=1);

namespace App\Mails\Services;

use App\Mails\Client\DomainExpiration;

final class DomainExpirationService
{
    /**
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Collection $domains
     * @param integer $domainNoticeNumberDays
     * @return void
     */
    public function execute(
        \App\Models\User $user,
        \Illuminate\Database\Eloquent\Collection $domains,
        int $domainNoticeNumberDays
    ): void {
        $user->notify(new DomainExpiration($domains, $domainNoticeNumberDays));
    }
}
