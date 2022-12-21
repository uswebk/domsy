<?php

declare(strict_types=1);

namespace App\Mails\Services;

use App\Mails\Client\DomainExpiration;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class DomainExpirationService
{
    /**
     * @param User $user
     * @param Collection $domains
     * @param integer $domainNoticeNumberDays
     * @return void
     */
    public function execute(User $user, Collection $domains, int $domainNoticeNumberDays): void
    {
        $user->notify(new DomainExpiration($domains, $domainNoticeNumberDays));
    }
}
