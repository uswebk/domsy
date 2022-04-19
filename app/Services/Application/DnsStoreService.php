<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Domain\Domain\ExistsService as DomainExistsService;

use Illuminate\Support\Facades\Auth;

final class DnsStoreService
{
    private $subdomainRepository;

    public function __construct(SubdomainRepositoryInterface $subdomainRepository)
    {
        $this->subdomainRepository = $subdomainRepository;
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
            $domainService = new DomainExistsService($domain_id, Auth::id());
            $exists = $domainService->isExists();

            if ($exists) {
                $this->subdomainRepository->store([
                    'prefix' => $prefix,
                    'domain_id' => $domain_id,
                    'type_id' => $type_id,
                    'value' => $value,
                    'ttl' => $ttl,
                    'priority' => $priority,
                ]);
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());

            throw $e;
        }
    }
}
