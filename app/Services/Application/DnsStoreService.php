<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;

use Illuminate\Support\Facades\Auth;

final class DnsStoreService
{
    private $subdomainRepository;
    private $domainQueryService;

    public function __construct(
        SubdomainRepositoryInterface $subdomainRepository,
        EloquentDomainQueryService $domainQueryService,
    ) {
        $this->subdomainRepository = $subdomainRepository;
        $this->domainQueryService = $domainQueryService;
    }

    public function handle(
        string $prefix,
        string $domain_id,
        string $type_id,
        string $value,
        string $ttl,
        string $priority,
    ) {
        try {
            $this->domainQueryService->getFirstOrFailByIdUserID($domain_id, Auth::id());

            $this->subdomainRepository->store([
                'prefix' => $prefix,
                'domain_id' => $domain_id,
                'type_id' => $type_id,
                'value' => $value,
                'ttl' => $ttl,
                'priority' => $priority,
            ]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());

            throw $e;
        }
    }
}
