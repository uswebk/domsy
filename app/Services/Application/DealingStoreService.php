<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\DomainNotExistsException;
use App\Exceptions\Client\NotOwnerException;
use App\Infrastructures\Models\Eloquent\DomainDealing;

use Exception;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class DealingStoreService
{
    private $dealingRepository;

    private $clientHasService;

    private $domainExistsService;

    /**
     * @param \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository
     * @param \App\Services\Domain\Client\HasService $clientHasService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository,
        \App\Services\Domain\Client\HasService $clientHasService,
        \App\Services\Domain\Domain\ExistsService $domainExistsService
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->clientHasService = $clientHasService;
        $this->domainExistsService = $domainExistsService;
    }

    /**
     * @param integer $intervalCategory
     * @return boolean
     */
    private function isExistsIntervalCategory(int $intervalCategory): bool
    {
        $intervalCategories = DomainDealing::getIntervalCategories();

        return isset($intervalCategories[$intervalCategory]);
    }

    /**
     * @param integer $userId
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
        int $userId,
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

            if (! $this->domainExistsService->exists($domainId, Auth::id())) {
                throw new DomainNotExistsException();
            }

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
        } catch (NotOwnerException | DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
