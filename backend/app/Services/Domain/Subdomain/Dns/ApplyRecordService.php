<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\Dns;

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
     * @param \App\Services\Domain\Subdomain\Dns\MakeRecordService $makeRecordService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
        \App\Services\Domain\Subdomain\Dns\MakeRecordService $makeRecordService
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
            $subdomain->delete();

            $dnsRecords = $this->makeRecordService->make($subdomain);
            if ($dnsRecords->isEmpty()) {
                $this->errorDomains[] = $domainName;
                return;
            }

            foreach ($dnsRecords as $dnsRecord) {
                if ($dnsRecord->getHost() === $subdomain->getFullDomainName()) {
                    $this->updateOfDnsRecordBySubdomain($dnsRecord, $subdomain);
                }
            }

            DB::commit();

            $this->successDomains[] = $domainName;
        } catch(Exception $e) {
            DB::rollBack();

            $this->errorDomains[] = $domainName;
        }
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
