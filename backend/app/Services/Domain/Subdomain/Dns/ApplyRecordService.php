<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\Dns;

use App\Exceptions\DnsRecordNotFoundException;
use App\Models\Subdomain;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class ApplyRecordService
{
    private MakeRecordService $makeRecordService;

    private SubdomainRepositoryInterface $subdomainRepository;

    private array $dnsRecordTypes;

    private array $successDomains = [];

    private array $errorDomains = [];

    /**
     * @param SubdomainRepositoryInterface $subdomainRepository
     * @param MakeRecordService $makeRecordService
     */
    public function __construct(
        SubdomainRepositoryInterface $subdomainRepository,
        MakeRecordService $makeRecordService
    ) {
        $this->makeRecordService = $makeRecordService;
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param RecordService $dnsRecord
     * @param Subdomain $subdomain
     * @return void
     */
    private function updateOfDnsRecordBySubdomain(RecordService $dnsRecord, Subdomain $subdomain): void
    {
        if (in_array($dnsRecord->getType(), $this->dnsRecordTypes)) {
            $this->subdomainRepository->updateOfTtlPriority(
                $subdomain->domain_id,
                $dnsRecord->getTypeId(),
                $subdomain->prefix,
                $dnsRecord->getValue(),
                $dnsRecord->getTtl(),
                $dnsRecord->getPriority(),
            );
        }
    }

    /**
     * @param Subdomain $subdomain
     * @return void
     */
    private function executeOfSubdomain(Subdomain $subdomain): void
    {
        $domainName = $subdomain->getDomainName();

        DB::beginTransaction();
        try {
            $subdomain->delete();

            $dnsRecords = $this->makeRecordService->make($subdomain);
            if ($dnsRecords->isEmpty()) {
                throw new DnsRecordNotFoundException();
            }

            foreach ($dnsRecords as $dnsRecord) {
                if ($dnsRecord->getHost() === $subdomain->getFullDomainName()) {
                    $this->updateOfDnsRecordBySubdomain($dnsRecord, $subdomain);
                }
            }

            DB::commit();

            $this->successDomains[] = $domainName;
        } catch (DnsRecordNotFoundException|Exception $e) {
            DB::rollBack();

            $this->errorDomains[] = $domainName;
        }
    }

    /**
     * @param Collection $subdomains
     * @param array $dnsRecordTypes
     * @return void
     */
    public function execute(Collection $subdomains, array $dnsRecordTypes): void
    {
        $this->dnsRecordTypes = $dnsRecordTypes;

        foreach ($subdomains as $subdomain) {
            $this->executeOfSubdomain($subdomain);
        }
    }

    /**
     * @return array
     */
    public function getSuccessDomains(): array
    {
        return array_unique($this->successDomains);
    }

    /**
     * @return array
     */
    public function getErrorDomains(): array
    {
        return array_unique($this->errorDomains);
    }
}
