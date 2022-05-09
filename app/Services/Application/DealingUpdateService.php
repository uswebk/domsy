<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface;
use App\Services\Domain\Client\HasService as ClientHasService;
use App\Services\Domain\Domain\ExistsService as DomainExistsService;

use Illuminate\Support\Facades\Auth;

final class DealingUpdateService
{
    private $dealingRepository;

    public function __construct(DomainDealingRepositoryInterface $dealingRepository)
    {
        $this->dealingRepository = $dealingRepository;
    }

    private function isExistsIntervalCategory(int $intervalCategory): bool
    {
        $intervalCategories = DomainDealing::getIntervalCategories();

        return isset($intervalCategories[$intervalCategory]);
    }

    public function handle(
        DomainDealing $domainDealing,
        int $domainId,
        int $clientId,
        int $subtotal,
        int $discount,
        \Carbon\Carbon $billingDate,
        int $interval,
        int $intervalCategory,
        bool $isAutoUpdate,
    ) {
        try {
            if (! $this->isExistsIntervalCategory($intervalCategory)) {
                throw new \Exception();
            }

            $domainService = new DomainExistsService($domainId, Auth::id());
            $clientService = new ClientHasService($clientId, Auth::id());

            if ($domainService->execute() && $clientService->execute()) {
                $domainDealing->fill([
                    'domain_id' => $domainId,
                    'client_id' => $clientId,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'billing_date' => $billingDate,
                    'interval' => $interval,
                    'interval_category' => $intervalCategory,
                    'is_auto_update' => $isAutoUpdate,
                ]);

                $this->dealingRepository->save($domainDealing);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
