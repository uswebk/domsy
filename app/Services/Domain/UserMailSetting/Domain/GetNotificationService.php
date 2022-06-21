<?php

declare(strict_types=1);

namespace App\Services\Domain\UserMailSetting\Domain;

use Illuminate\Database\Eloquent\Collection;

final class GetNotificationService
{
    private $notificationDomains;

    private $domainExpirationMailSetting;

    private $user;

    private $targetDate;

    /**
     * @return void
     */
    private function initNotificationDomains(): void
    {
        $domainNoticeNumberDays = $this->domainExpirationMailSetting->notice_number_days;

        $notificationDate = $this->targetDate->copy()->addDays($domainNoticeNumberDays);

        $domains = $this->user->domains;

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
        $this->domainExpirationMailSetting = $domainExpirationMailSetting;
        $this->user = $user;
        $this->targetDate = $targetDate;

        $this->initNotificationDomains();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDomains(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->notificationDomains;
    }
}
