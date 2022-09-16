<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\DNS;

use Exception;
use Illuminate\Support\Facades\DB;

final class ApplyRecordService
{
    private $makeRecordService;

    private $dnsRecordTypes;

    private $subdomainRepository;

    private $successDomains = [];

    private $errorDomains = [];

    /**
     * @param \App\Services\Domain\Subdomain\DNS\MakeRecordService $makeRecordService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
        \App\Services\Domain\Subdomain\DNS\MakeRecordService $makeRecordService
    ) {
        $this->makeRecordService = $makeRecordService;
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param \App\Services\Domain\Subdomain\Dns\RecordService $dnsRecord
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return void
     */
    private function updateOfDnsRecordBySubdomain(
        \App\Services\Domain\Subdomain\Dns\RecordService $dnsRecord,
        \App\Infrastructures\Models\Subdomain $subdomain
    ): void {
        $subdomain->delete();

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
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return void
     */
    private function executeOfSubdomain(
        \App\Infrastructures\Models\Subdomain $subdomain
    ): void {
        $domainName = $subdomain->getDomainName();

        DB::beginTransaction();
        try {
            $dnsRecords = $this->makeRecordService->make($subdomain);
            foreach ($dnsRecords as $dnsRecord) {
                $this->updateOfDnsRecordBySubdomain($dnsRecord, $subdomain);
            }
            $this->successDomains[] = $domainName;

            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();

            $this->errorDomains[] = $domainName;
        }

        $this->successDomains = array_unique($this->successDomains);
        $this->errorDomains = array_unique($this->errorDomains);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $subdomains
     * @param array $dnsRecordTypes
     * @return void
     */
    public function execute(
        \Illuminate\Database\Eloquent\Collection $subdomains,
        array $dnsRecordTypes,
    ): void {
        $this->dnsRecordTypes = $dnsRecordTypes;

        $subdomainCollapses = $subdomains->collapse();
        foreach ($subdomainCollapses as $subdomain) {
            $this->executeOfSubdomain($subdomain);
        }
    }

    /**
     * @return array
     */
    public function getSuccessDomains(): array
    {
        return $this->successDomains;
    }

    /**
     * @return array
     */
    public function getErrorDomains(): array
    {
        return $this->errorDomains;
    }
}
