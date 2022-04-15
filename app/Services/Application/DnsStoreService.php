<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;
use App\Infrastructures\Repositories\Domain\DomainDnsRecordRepositoryInterface;

use Illuminate\Support\Facades\Auth;

final class DnsStoreService
{
    private $domainDnsRecordRepository;
    private $domainQueryService;

    public function __construct(
        DomainDnsRecordRepositoryInterface $domainDnsRecordRepository,
        EloquentDomainQueryService $domainQueryService,
    ) {
        $this->domainDnsRecordRepository = $domainDnsRecordRepository;
        $this->domainQueryService = $domainQueryService;
    }

    public function handle(
        string $subdomain,
        string $domain_id,
        string $type_id,
        string $value,
        string $ttl,
        string $priority,
    ) {
        try {
            $this->domainQueryService->getFirstOrFailByIdUserID($domain_id, Auth::id());

            $this->domainDnsRecordRepository->store([
                'subdomain' => $subdomain,
                'domain_id' => $domain_id,
                'type_id' => $type_id,
                'value' => $value,
                'ttl' => $ttl,
                'priority' => $priority,
            ]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());

            throw $e;
        }
    }
}
