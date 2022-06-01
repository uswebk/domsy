<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\NotOwnerException;
use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Services\Domain\Domain\ExistsService as DomainExistsService;
use Exception;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

final class DealingUpdateService
{
    private $dealingRepository;

    private $clientHasService;

    /**
     * @param \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository,
        \App\Services\Domain\Client\HasService $clientHasService
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->clientHasService = $clientHasService;
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
                throw new Exception();
            }


            if (! $this->clientHasService->isOwner($clientId, Auth::id())) {
                throw new NotOwnerException();
            }

            $domainService = new DomainExistsService($domainId, Auth::id());

            if ($domainService->exists()) {
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
