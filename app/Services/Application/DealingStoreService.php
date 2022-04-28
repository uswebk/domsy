<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface;

final class DealingStoreService
{
    private $dealingRepository;

    public function __construct(DomainDealingRepositoryInterface $dealingRepository)
    {
        $this->dealingRepository = $dealingRepository;
    }

    public function handle(
        int $user_id,
        int $domain_id,
        int $client_id,
        string $subtotal,
        string $discount,
        string $billing_date,
        string $interval,
        string $interval_category,
        string $is_auto_update,
    ) {

        // Todo:ドメイン整合性Check

        // Todo:クライアント整合性Check

        $this->dealingRepository->store([
            'user_id' => $user_id,
            'domain_id' => $domain_id,
            'client_id' => $client_id,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'billing_date' => $billing_date,
            'interval' => $interval,
            'interval_category' => $interval_category,
            'is_auto_update' => $is_auto_update,
        ]);
    }
}
