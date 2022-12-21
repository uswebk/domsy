<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchActiveSummaryService
{
    private $domainSummary;

    /**
     * @param \App\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());
        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->domainSummary = $eloquentDomainQueryService->getActiveCountByUserIds($userIds);
    }

    /**
     * @return \App\Models\Domain
     */
    public function getResponse(): \App\Models\Domain
    {
        return $this->domainSummary;
    }
}
