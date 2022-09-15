<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

final class UpdateDomainService
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
     * @param \App\Infrastructures\Models\Domain $domain
     * @return \App\Infrastructures\Models\Domain
     */
    public function execute(\App\Infrastructures\Models\Domain $domain): \App\Infrastructures\Models\Domain
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
