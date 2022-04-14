<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Repositories\Domain\DomainDnsRecordRepositoryInterface;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;

final class DomainStoreService
{
    private $domainRepository;
    private $domainDnsRecordRepository;

    public function __construct(
        DomainRepositoryInterface $domainRepository,
        DomainDnsRecordRepositoryInterface $domainDnsRecordRepository,
    ) {
        $this->domainRepository = $domainRepository;
        $this->domainDnsRecordRepository = $domainDnsRecordRepository;
    }

    public function handle(array $attributes)
    {
        \DB::beginTransaction();
        try {
            $domain = $this->domainRepository->store($attributes);

            $this->domainDnsRecordRepository->store([
                'domain_id' => $domain->id,
                'subdomain' => null,
            ]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }
}
