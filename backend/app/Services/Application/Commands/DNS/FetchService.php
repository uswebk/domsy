<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\DNS;

use Exception;

final class FetchService
{
    private $dnsRecodeTypeQueryService;

    private $applyRecordService;

    /**
     * @param \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService
     * @param \App\Services\Domain\Subdomain\DNS\ApplyRecordService $applyRecordService
     */
    public function __construct(
        \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService,
        \App\Services\Domain\Subdomain\DNS\ApplyRecordService $applyRecordService
    ) {
        $this->dnsRecodeTypeQueryService = $dnsRecodeTypeQueryService;
        $this->applyRecordService = $applyRecordService;
    }

    /**
     * @return array
     */
    private function getDnsRecodeTypeNames(): array
    {
        $dnsRecordTypes = $this->dnsRecodeTypeQueryService->getSortAll();

        return $dnsRecordTypes->pluck('name', 'id')->toArray();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $subdomains
     * @return void
     */
    public function handle(
        \Illuminate\Database\Eloquent\Collection $subdomains
    ): void {
        try {
            $this->applyRecordService->execute($subdomains, $this->getDnsRecodeTypeNames());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
