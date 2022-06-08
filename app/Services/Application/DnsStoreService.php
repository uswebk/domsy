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
     * @param \App\Services\Application\InputData\DnsStoreRequest $dnsStoreRequest
     *
     * @throws DomainNotExistsException
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DnsStoreRequest $dnsStoreRequest
    ): void {
        $subdomainRequest = $dnsStoreRequest->getInput();
        $domainId = $subdomainRequest->domain_id;

        try {
            if (! $this->domainExistsService->exists($domainId, Auth::id())) {
                throw new DomainNotExistsException();
            }

            $this->subdomainRepository->store([
                'prefix' => $subdomainRequest->prefix,
                'domain_id' => $domainId,
                'type_id' => $subdomainRequest->type_id,
                'value' => $subdomainRequest->value,
                'ttl' => $subdomainRequest->ttl,
                'priority' => $subdomainRequest->priority,
            ]);
        } catch (DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
