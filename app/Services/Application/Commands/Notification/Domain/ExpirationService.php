<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Notification\Domain;

use App\Infrastructures\Mails\SendServices\DomainExpirationService;

use App\Infrastructures\Queries\User\EloquentUserQueryService;
use Illuminate\Database\Eloquent\Collection;

final class ExpirationService
{
    private $eloquentUserQueryService;
    private $domainExpirationService;

    public function __construct(
        EloquentUserQueryService $eloquentUserQueryService,
        DomainExpirationService $domainExpirationService
    ) {
        $this->eloquentUserQueryService = $eloquentUserQueryService;
        $this->domainExpirationService = $domainExpirationService;
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

            $this->domainExpirationService->execute($user, $domainExpirationList);
        }
    }
}
