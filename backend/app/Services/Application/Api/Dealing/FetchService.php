<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private $domainDealings;

    /**
     * @param \App\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());

        $this->domainDealings = new Collection();

        if ($user->isCompany()) {
            $domains = $eloquentDomainQueryService->getByUserIds($user->getMemberIds());
        } else {
            $domains = $user->domains;
        }

        $domains->load([
            'domainDealings',
            'domainDealings.client',
        ]);

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponse(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DomainDealingResource::collection($this->domainDealings);
    }
}
