<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dns;

use App\Http\Resources\DnsResource;
use App\Models\User;
use App\Queries\Domain\DomainQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $domains;

    /**
     * @param DomainQueryServiceInterface $domainQueryService
     */
    public function __construct(DomainQueryServiceInterface $domainQueryService)
    {
        $user = User::find(Auth::id());

        $this->domains = $domainQueryService->getByUserIds($user->getMemberIds());
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return DnsResource::collection($this->domains);
    }
}
