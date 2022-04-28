<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface;
use App\Services\Domain\Domain\ExistsService as DomainExistsService;

final class DealingStoreService
{
    private $dealingRepository;

    public function __construct(DomainDealingRepositoryInterface $dealingRepository)
    {
        $this->dealingRepository = $dealingRepository;
    }

    public function handle(
        int $userId,
        int $domainId,
        int $clientId,
        string $subtotal,
        string $discount,
        string $billingDate,
        string $interval,
        string $intervalCategory,
        string $isAutoUpdate,
    ) {
        $domainService = new DomainExistsService($domainId, Auth::id());

        // Todo:クライアント整合性Check

        if ($domainService->execute()) {
            $this->dealingRepository->store([
                'user_id' => $userId,
                'domain_id' => $domainId,
                'client_id' => $clientId,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'billing_date' => $billingDate,
                'interval' => $interval,
                'interval_category' => $intervalCategory,
                'is_auto_update' => $isAutoUpdate,
            ]);
        }
    }
}
