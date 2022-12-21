<?php

declare(strict_types=1);

namespace App\Services\Domain\UserMailSetting;

use Illuminate\Database\Eloquent\Collection;

final class ExpirationDomainService
{
    private $notificationDomains;

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $notificationDate
     * @return void
     */
    private function initNotificationDomains(
        \App\Models\User $user,
        \Carbon\Carbon $notificationDate,
    ): void {
        $domains = $user->domains;

        foreach ($domains as $domain) {
            if (!$domain->isExpirationDateByTargetDate($notificationDate)) {
                continue;
            }

            if (!$domain->isOwned()) {
                continue;
            }

            $this->notificationDomains->push($domain);
        }
    }

    /**
     * @param \App\Models\UserMailSetting $domainExpirationMailSetting
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $targetDate
     */
    public function __construct(
        \App\Models\UserMailSetting $domainExpirationMailSetting,
        \App\Models\User $user,
        \Carbon\Carbon $targetDate,
    ) {
        $this->notificationDomains = new Collection();

        $noticeNumberDaysOfDomain = $domainExpirationMailSetting->notice_number_days;
        $notificationDate = $targetDate->copy()->addDays($noticeNumberDaysOfDomain);

        $this->initNotificationDomains($user, $notificationDate);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDomains(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->notificationDomains;
    }
}
