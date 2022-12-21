<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Resources\DomainResource;
use App\Models\User;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class FetchSortExpiredService
{
    private Collection $domains;

    private const DEFAULT_TAKE = 5;

    /**
     * @param Request $request
     * @param EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        Request $request,
        EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $take = $request->take ?? self::DEFAULT_TAKE;

        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->domains = $eloquentDomainQueryService->getActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt(
            $userIds,
            now()->startOfDay(),
            (int) $take
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
