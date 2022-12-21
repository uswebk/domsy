<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Notification\Domain;

use App\Services\Domain\UserMailSetting\ExpirationDomainService;

final class ExpirationService
{
    private $eloquentUserQueryService;

    private $domainExpirationService;

    /**
     * @param \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService
     * @param \App\Mails\Services\DomainExpirationService $domainExpirationService
     */
    public function __construct(
        \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService,
        \App\Mails\Services\DomainExpirationService $domainExpirationService
    ) {
        $this->eloquentUserQueryService = $eloquentUserQueryService;
        $this->domainExpirationService = $domainExpirationService;
    }

    /**
     * @param \Carbon\Carbon $executeDate
     * @return void
     */
    public function handle(\Carbon\Carbon $executeDate): void
    {
        $users = $this->eloquentUserQueryService->getActiveUsers();

        foreach ($users as $user) {
            $domainExpirationMailSetting = $user->getReceiveDomainExpirationMailSetting();

            if (!isset($domainExpirationMailSetting)) {
                continue;
            }

            if ($domainExpirationMailSetting->isRejection()) {
                continue;
            }

            $notificationDomains = (new ExpirationDomainService(
                $domainExpirationMailSetting,
                $user,
                $executeDate
            ))->getDomains();

            if ($notificationDomains->isNotEmpty()) {
                $this->domainExpirationService->execute($user, $notificationDomains, $domainExpirationMailSetting->notice_number_days);
            }
        }
    }
}
