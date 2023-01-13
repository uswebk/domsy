<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Models\Domain;
use App\Repositories\Domain\DomainRepositoryInterface;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;

final class RenewService
{
    private DomainRepositoryInterface $domainRepository;

    private SubdomainRepositoryInterface $subdomainRepository;

    /**
     * @param DomainRepositoryInterface $domainRepository
     * @param SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        DomainRepositoryInterface $domainRepository,
        SubdomainRepositoryInterface $subdomainRepository,
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param Domain $domain
     * @return Domain
     */
    public function execute(Domain $domain): Domain
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
