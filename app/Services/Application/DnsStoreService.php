<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Queries\DNS\EloquentDomainQueryService;
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

    public function handle(array $attributes)
    {
        try {
            $this->domainQueryService->getFirstOrFailByIdUserID($attributes['domain_id'], Auth::id());

            $this->domainDnsRecordRepository->store($attributes);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
