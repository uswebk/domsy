<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchActiveSummaryService
{
    private $domainSummary;

    /**
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());
        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->domainSummary = $eloquentDomainQueryService->getAggregatedActiveCountByUserIds($userIds);
    }

    /**
     * @return \App\Infrastructures\Models\Domain
     */
    public function getResponse(): \App\Infrastructures\Models\Domain
    {
        return $this->domainSummary;
    }
}
