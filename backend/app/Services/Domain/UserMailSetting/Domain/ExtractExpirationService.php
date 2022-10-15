<?php

declare(strict_types=1);

namespace App\Services\Domain\UserMailSetting\Domain;

use Illuminate\Database\Eloquent\Collection;

final class ExtractExpirationService
{
    private $notificationDomains;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \Carbon\Carbon $notificationDate
     * @return void
     */
    private function initNotificationDomains(
        \App\Infrastructures\Models\User $user,
        \Carbon\Carbon $notificationDate,
    ): void {
        $domains = $user->domains;

        foreach ($domains as $domain) {
            if (! $domain->isExpirationDateByTargetDate($notificationDate)) {
                continue;
            }

            if (! $domain->isOwned()) {
                continue;
            }

            $this->notificationDomains->push($domain);
        }
    }

    /**
     * @param \App\Infrastructures\Models\UserMailSetting $domainExpirationMailSetting
     * @param \App\Infrastructures\Models\User $user
     * @param \Carbon\Carbon $targetDate
     */
    public function __construct(
        \App\Infrastructures\Models\UserMailSetting $domainExpirationMailSetting,
        \App\Infrastructures\Models\User $user,
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
