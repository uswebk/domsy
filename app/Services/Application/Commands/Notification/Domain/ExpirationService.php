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

    public function isReceivedMailByUser(
        \App\Infrastructures\Models\Eloquent\User $user
    ): bool {
        $domainExpirationMailSetting = $user->getReceiveDomainExpirationMailSetting();

        if (! isset($domainExpirationMailSetting)) {
            return false;
        }

        if ($domainExpirationMailSetting->isRejection()) {
            return false;
        }

        return true;
    }

    public function handle(\Illuminate\Support\Carbon $targetDate): void
    {
        $users = $this->eloquentUserQueryService->getByDeletedAtNull();

        foreach ($users as $user) {
            if ($this->isReceivedMailByUser($user)) {
                continue;
            }

            $domainExpirationList = new Collection();

            $domains = $user->domains;
            foreach ($domains as $domain) {
                if ($domain->isExpirationDateByTargetDate($targetDate)) {
                    $domainExpirationList->push($domain);
                }
            }

            // ユーザー情報とドメインリストを受け取りメール送信
        }
    }
}
