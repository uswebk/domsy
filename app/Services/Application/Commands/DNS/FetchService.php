<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\DNS;

use Exception;
use Illuminate\Support\Facades\DB;

final class FetchService
{
    private $dnsRecodeTypeQueryService;

    private $registrationService;

    private $makeDnsRecordService;

    private $dnsTypes;

    public function __construct(
        \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService,
        \App\Services\Domain\Subdomain\DNS\RegistrationService $registrationService,
        \App\Services\Domain\Subdomain\DNS\MakeDnsRecordService $makeDnsRecordService
    ) {
        $this->dnsRecodeTypeQueryService = $dnsRecodeTypeQueryService;
        $this->registrationService = $registrationService;
        $this->makeDnsRecordService = $makeDnsRecordService;
    }

    /**
     * @return void
     */
    private function initDnsRecodeTypeNames(): void
    {
        $dnsRecordTypes = $this->dnsRecodeTypeQueryService->getSortAll();

        $this->dnsTypes = $dnsRecordTypes->pluck('name', 'id')->toArray();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $subdomains
     * @return void
     */
    public function handle(
        \Illuminate\Database\Eloquent\Collection $subdomains
    ): void {
        $this->initDnsRecodeTypeNames();

        $subdomainCollapse = $subdomains->collapse();

        DB::beginTransaction();
        try {
            foreach ($subdomainCollapse as $subdomain) {
                $dnsRecords = $this->makeDnsRecordService->make($subdomain);

                $domainId = $subdomain->domain_id;
                $prefix = $subdomain->prefix;

                $subdomain->delete();

                foreach ($dnsRecords as $dnsRecord) {
                    $this->registrationService->execute($dnsRecord, $domainId, $prefix, $this->dnsTypes);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
