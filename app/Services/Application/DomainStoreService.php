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

    public function handle(
        string $name,
        string $price,
        int $user_id,
        string $is_active,
        string $is_transferred,
        string $is_management_only,
        string $purchased_at,
        string $expired_at,
        ?string $canceled_at,
    ) {
        \DB::beginTransaction();
        try {
            $domain = $this->domainRepository->store([
                'name' => $name,
                'price' => $price,
                'user_id' => $user_id,
                'is_active' => $is_active,
                'is_transferred' => $is_transferred,
                'is_management_only' => $is_management_only,
                'purchased_at' => $purchased_at,
                'expired_at' => $expired_at,
                'canceled_at' => $canceled_at,
            ]);

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
