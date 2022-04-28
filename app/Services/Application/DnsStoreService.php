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
        int $domainId,
        string $typeId,
        string $value,
        string $ttl,
        ?string $priority,
    ) {
        try {
            $domainService = new DomainExistsService($domainId, Auth::id());

            if ($domainService->execute()) {
                $this->subdomainRepository->store([
                    'prefix' => $prefix,
                    'domain_id' => $domainId,
                    'type_id' => $typeId,
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
