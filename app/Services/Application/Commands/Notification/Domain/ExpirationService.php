<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Notification\Domain;

use App\Infrastructures\Queries\User\EloquentUserQueryService;

use Illuminate\Database\Eloquent\Collection;

final class ExpirationService
{
    private $eloquentUserQueryService;

    public function __construct(EloquentUserQueryService $eloquentUserQueryService)
    {
        $this->eloquentUserQueryService = $eloquentUserQueryService;
    }

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
            $notificationDate = $targetDate->addDays($domainExpirationMailSetting->notice_number_days);

            $domains = $user->domains;
            foreach ($domains as $domain) {
                if ($domain->isExpirationDateByTargetDate($notificationDate)) {
                    $domainExpirationList->push($domain);
                }
            }

            // MailSendService -> user, domainExpirationList
        }
    }
}
