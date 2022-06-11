<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\DNS;

final class RegistrationService
{
    private $subdomainRepository;

    /**
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
    ) {
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param \App\Infrastructures\Models\DnsRecord $dnsRecord
     * @param integer $domainId
     * @param string $prefix
     * @param array $dnsTypes
     * @return void
     */
    public function execute(
        \App\Infrastructures\Models\DnsRecord $dnsRecord,
        int $domainId,
        string $prefix,
        array $dnsTypes
    ): void {
        if (in_array($dnsRecord->getType(), $dnsTypes)) {
            $this->subdomainRepository->updateOfTtlPriority(
                $domainId,
                $dnsRecord->getTypeId(),
                $prefix,
                $dnsRecord->getValue(),
                $dnsRecord->getTtl(),
                $dnsRecord->getPriority(),
            );
        }
    }
}
