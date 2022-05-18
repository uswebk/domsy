<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Services\Domain\Domain\ExistsService as DomainExistsService;

use Illuminate\Support\Facades\Auth;

final class DnsStoreService
{
    private $subdomainRepository;

    /**
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(\App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository)
    {
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param string $prefix
     * @param integer $domainId
     * @param string $typeId
     * @param string $value
     * @param string $ttl
     * @param string|null $priority
     * @return void
     */
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
