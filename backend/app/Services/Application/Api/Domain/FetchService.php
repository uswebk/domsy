<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Resources\DomainResource;
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

        if ($user->isCompany()) {
            $this->domains = $domainQueryService->getByUserIds($user->getMemberIds());
        } else {
            $this->domains = $user->domains;
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return DomainResource::collection($this->domains);
    }
}
