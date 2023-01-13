<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Dns;

use App\Queries\Dns\DnsRecordTypeQueryServiceInterface;
use App\Services\Domain\Subdomain\Dns\ApplyRecordService;
use Illuminate\Database\Eloquent\Collection;

final class FetchService
{
    private DnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService;

    private ApplyRecordService $applyRecordService;

    /**
     * @param DnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService
     * @param ApplyRecordService $applyRecordService
     */
    public function __construct(
        DnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService,
        ApplyRecordService $applyRecordService
    ) {
        $this->dnsRecodeTypeQueryService = $dnsRecodeTypeQueryService;
        $this->applyRecordService = $applyRecordService;
    }

    /**
     * @param Collection $subdomains
     * @return void
     */
    public function handle(Collection $subdomains): void
    {
        $dnsRecordTypes = $this->dnsRecodeTypeQueryService->getSortAll();
        $dnsRecordTypeNames = $dnsRecordTypes->pluck('name', 'id')->toArray();

        $this->applyRecordService->execute($subdomains, $dnsRecordTypeNames);
    }
}
