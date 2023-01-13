<?php

declare(strict_types=1);

namespace App\Services\Domain\UserMailSetting;

use App\Models\User;
use App\Models\UserMailSetting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

final class ExpirationDomainService
{
    private Collection $notificationDomains;

    /**
     * @param User $user
     * @param Carbon $notificationDate
     * @return void
     */
    private function initNotificationDomains(User $user, Carbon $notificationDate): void
    {
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
     * @param UserMailSetting $domainExpirationMailSetting
     * @param User $user
     * @param Carbon $targetDate
     */
    public function __construct(
        UserMailSetting $domainExpirationMailSetting,
        User $user,
        Carbon $targetDate,
    ) {
        $this->notificationDomains = new Collection();

        $noticeNumberDaysOfDomain = $domainExpirationMailSetting->notice_number_days;
        $notificationDate = $targetDate->copy()->addDays($noticeNumberDaysOfDomain);

        $this->initNotificationDomains($user, $notificationDate);
    }

    /**
     * @return Collection
     */
    public function getDomains(): Collection
    {
        return $this->notificationDomains;
    }
}
