<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Services\Domain\Client\HasService as ClientHasService;
use App\Services\Domain\Domain\ExistsService as DomainExistsService;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

final class DealingUpdateService
{
    private $dealingRepository;

    /**
     * @param \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository
    ) {
        $this->dealingRepository = $dealingRepository;
    }

    private function isExistsIntervalCategory(int $intervalCategory): bool
    {
        $intervalCategories = DomainDealing::getIntervalCategories();

        return isset($intervalCategories[$intervalCategory]);
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @param integer $domainId
     * @param integer $clientId
     * @param integer $subtotal
     * @param integer $discount
     * @param Carbon $billingDate
     * @param integer $interval
     * @param integer $intervalCategory
     * @param boolean $isAutoUpdate
     * @return void
     */
    public function handle(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing,
        int $domainId,
        int $clientId,
        int $subtotal,
        int $discount,
        Carbon $billingDate,
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
