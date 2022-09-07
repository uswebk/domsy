<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Resources\DomainResource;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchSortExpiredService
{
    private $domains;

    private const DEFAULT_TAKE = 5;

    /**
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $take = $request->take ?? self::DEFAULT_TAKE;

        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->domains = $eloquentDomainQueryService->getSortExpiredByUserIdsExpiredGreaterThanTargetDatetimeTake(
            $userIds,
            now()->startOfDay(),
            (int)$take
        );
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponse(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DomainResource::collection($this->domains);
    }
}
