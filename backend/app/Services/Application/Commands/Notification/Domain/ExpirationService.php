<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Notification\Domain;

use App\Mails\Services\DomainExpirationService;
use App\Queries\User\UserQueryServiceInterface;
use App\Services\Domain\UserMailSetting\ExpirationDomainService;

final class ExpirationService
{
    private UserQueryServiceInterface $userQueryService;

    private DomainExpirationService $domainExpirationService;

    /**
     * @param UserQueryServiceInterface $userQueryService
     * @param DomainExpirationService $domainExpirationService
     */
    public function __construct(
        UserQueryServiceInterface $userQueryService,
        DomainExpirationService $domainExpirationService
    ) {
        $this->userQueryService = $userQueryService;
        $this->domainExpirationService = $domainExpirationService;
    }

    /**
     * @param \Carbon\Carbon $executeDate
     * @return void
     */
    public function handle(\Carbon\Carbon $executeDate): void
    {
        $users = $this->userQueryService->getActiveUsers();

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
                $this->domainExpirationService->execute(
                    $user,
                    $notificationDomains,
                    $domainExpirationMailSetting->notice_number_days
                );
            }
        }
    }
}
