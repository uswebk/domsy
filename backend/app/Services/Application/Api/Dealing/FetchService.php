<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use App\Models\User;
use App\Queries\Domain\DomainQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $domainDealings;

    /**
     * @param DomainQueryServiceInterface $domainQueryService
     */
    public function __construct(DomainQueryServiceInterface $domainQueryService)
    {
        $user = User::find(Auth::id());

        $this->domainDealings = new Collection();

        if ($user->isCompany()) {
            $domains = $domainQueryService->getByUserIds($user->getMemberIds());
        } else {
            $domains = $user->domains;
        }

        $domains->load(['domainDealings', 'domainDealings.client',]);

        foreach ($domains as $domain) {
            if ($domain->domainDealings->isEmpty()) {
                continue;
            }

            foreach ($domain->domainDealings as $domainDealing) {
                $this->domainDealings->push($domainDealing);
            }
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return DomainDealingResource::collection($this->domainDealings);
    }
}
