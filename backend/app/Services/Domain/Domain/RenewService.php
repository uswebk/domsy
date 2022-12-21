<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

final class RenewService
{
    private $domainRepository;

    private $subdomainRepository;

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository,
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param \App\Models\Domain $domain
     * @return \App\Models\Domain
     */
    public function execute(\App\Models\Domain $domain): \App\Models\Domain
    {
        $dirty = $domain->getDirty();
        if (isset($dirty['name'])) {
            $domain->subdomains()->delete();

            $this->subdomainRepository->store([
                'domain_id' => $domain->id,
                'subdomain' => '',
            ]);
        }
        return $this->domainRepository->save($domain);
    }
}
