<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dns;

use App\Http\Resources\SubdomainResource;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Application\InputData\DnsStoreRequest;

final class StoreService
{
    private $subdomainRepository;

    private $subdomain;

    /**
     * @param SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(SubdomainRepositoryInterface $subdomainRepository)
    {
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param DnsStoreRequest $dnsStoreRequest
     * @return void
     */
    public function handle(DnsStoreRequest $dnsStoreRequest): void
    {
        $subdomainRequest = $dnsStoreRequest->getInput();

        $this->subdomain = $this->subdomainRepository->store([
            'prefix' => $subdomainRequest->prefix,
            'domain_id' => $subdomainRequest->domain_id,
            'type_id' => $subdomainRequest->type_id,
            'value' => $subdomainRequest->value,
            'ttl' => $subdomainRequest->ttl,
            'priority' => $subdomainRequest->priority,
        ]);
    }

    /**
     * @return SubdomainResource
     */
    public function getResponse(): SubdomainResource
    {
        return new SubdomainResource($this->subdomain);
    }
}
