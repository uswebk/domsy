<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Models\Domain;
use App\Models\User;
use App\Queries\Domain\DomainQueryServiceInterface;
use Illuminate\Support\Facades\Auth;

final class FetchActiveSummaryService
{
    private Domain $domainSummary;

    /**
     * @param DomainQueryServiceInterface $domainQueryService
     */
    public function __construct(DomainQueryServiceInterface $domainQueryService)
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->domainSummary = $domainQueryService->getActiveCountByUserIds($userIds);
    }

    /**
     * @return Domain
     */
    public function getResponse(): Domain
    {
        return $this->domainSummary;
    }
}
