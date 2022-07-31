<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\DnsResource;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class DnsFetchService
{
    private $domains;

    /**
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->domains = $eloquentDomainQueryService->getByUserIds($user->getMemberIds());
        } else {
            $this->domains = $user->domains;
        }

        $this->domains->load([
            'subdomains',
            'subdomains.dnsRecordType'
        ]);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DnsResource::collection($this->domains);
    }
}
