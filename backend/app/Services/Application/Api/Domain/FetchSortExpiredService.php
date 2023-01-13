<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Resources\DomainResource;
use App\Models\User;
use App\Queries\Domain\DomainQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchSortExpiredService
{
    private Collection $domains;

    private const DEFAULT_TAKE = 5;

    /**
     * @param Request $request
     * @param DomainQueryServiceInterface $domainQueryService
     */
    public function __construct(Request $request, DomainQueryServiceInterface $domainQueryService)
    {
        $take = $request->take ?? self::DEFAULT_TAKE;

        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->domains = $domainQueryService->getActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt(
            $userIds,
            now()->startOfDay(),
            (int) $take
        );
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return DomainResource::collection($this->domains);
    }
}
