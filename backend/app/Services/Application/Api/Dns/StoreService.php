<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dns;

use App\Http\Resources\SubdomainResource;
use Exception;

final class StoreService
{
    private $subdomainRepository;

    private $subdomain;

    /**
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
    ) {
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param \App\Services\Application\InputData\DnsStoreRequest $dnsStoreRequest
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DnsStoreRequest $dnsStoreRequest
    ): void {
        $subdomainRequest = $dnsStoreRequest->getInput();

        try {
            $this->subdomain = $this->subdomainRepository->store([
                'prefix' => $subdomainRequest->prefix,
                'domain_id' => $subdomainRequest->domain_id,
                'type_id' => $subdomainRequest->type_id,
                'value' => $subdomainRequest->value,
                'ttl' => $subdomainRequest->ttl,
                'priority' => $subdomainRequest->priority,
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return \App\Http\Resources\SubdomainResource
     */
    public function getResponse(): \App\Http\Resources\SubdomainResource
    {
        return new SubdomainResource($this->subdomain);
    }
}
