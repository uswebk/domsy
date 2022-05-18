<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Notification\Domain;

use Illuminate\Database\Eloquent\Collection;

final class ExpirationService
{
    private $eloquentUserQueryService;

    private $domainExpirationService;

    /**
     * @param \App\Infrastructures\Queries\User\EloquentUserQueryService $eloquentUserQueryService
     * @param \App\Infrastructures\Mails\Services\DomainExpirationService $domainExpirationService
     */
    public function __construct(
        \App\Infrastructures\Queries\User\EloquentUserQueryService $eloquentUserQueryService,
        \App\Infrastructures\Mails\Services\DomainExpirationService $domainExpirationService
    ) {
        $this->eloquentUserQueryService = $eloquentUserQueryService;
        $this->domainExpirationService = $domainExpirationService;
    }

    /**
     * @param \Illuminate\Support\Carbon $targetDate
     * @return void
     */
    public function handle(\Illuminate\Support\Carbon $targetDate): void
    {
        $users = $this->eloquentUserQueryService->getByDeletedAtNull();
        foreach ($users as $user) {
            $domainExpirationMailSetting = $user->getReceiveDomainExpirationMailSetting();

            if (! isset($domainExpirationMailSetting)) {
                continue;
            }

            if ($domainExpirationMailSetting->isRejection()) {
                continue;
            }

            $domainExpirationList = new Collection();

            $domainNoticeNumberDays = $domainExpirationMailSetting->notice_number_days;
            $notificationDate = $targetDate->addDays($domainNoticeNumberDays);

            $domains = $user->domains;
            foreach ($domains as $domain) {
                if (! $domain->isExpirationDateByTargetDate($notificationDate)) {
                    continue;
                }

                if (! $domain->isOwned()) {
                    continue;
                }

                $domainExpirationList->push($domain);
            }

            if ($domainExpirationList->isNotEmpty()) {
                $this->domainExpirationService->execute($user, $domainExpirationList, $domainNoticeNumberDays);
            }
        }
    }
}
