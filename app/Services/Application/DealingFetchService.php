<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\DealingResource;
use App\Infrastructures\Models\User;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class DealingFetchService
{
    private $domains;

    /**
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());

        $this->domains = new Collection();

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

            $this->domains->push($domain);
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DealingResource::collection($this->domains);
    }
}
