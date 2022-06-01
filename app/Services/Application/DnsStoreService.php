<?php

declare(strict_types=1);

namespace App\Services\Application;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class DnsStoreService
{
    private $subdomainRepository;

    private $domainExistsService;

    /**
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     * @param \App\Services\Domain\Domain\ExistsService $domainExistsService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
        \App\Services\Domain\Domain\ExistsService $domainExistsService
    ) {
        $this->subdomainRepository = $subdomainRepository;
        $this->domainExistsService = $domainExistsService;
    }

    /**
     * @param string $prefix
     * @param integer $domainId
     * @param integer $typeId
     * @param string $value
     * @param integer $ttl
     * @param integer $priority
     *
     * @throws DomainNotExistsException
     *
     * @return void
     */
    public function handle(
        string $prefix,
        int $domainId,
        int $typeId,
        string $value,
        int $ttl,
        int $priority,
    ): void {
        try {
            if (! $this->domainExistsService->exists($domainId, Auth::id())) {
                throw new DomainNotExistsException();
            }

            $this->subdomainRepository->store([
                'prefix' => $prefix,
                'domain_id' => $domainId,
                'type_id' => $typeId,
                'value' => $value,
                'ttl' => $ttl,
                'priority' => $priority,
            ]);
        } catch (DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
