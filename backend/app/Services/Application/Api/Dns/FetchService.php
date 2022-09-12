<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dns;

use App\Http\Resources\DnsResource;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private $domains;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());
        $this->domains = $eloquentDomainQueryService
        ->getPageNationByUserIdsPage($user->getMemberIds(), (int) $request->size);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponse(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DnsResource::collection($this->domains);
    }
}
