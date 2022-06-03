<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\DomainNotExistsException;
use App\Exceptions\Client\NotOwnerException;
use App\Infrastructures\Models\Eloquent\DomainDealing;

use Exception;

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
     * @param \App\Services\Domain\Domain\ExistsService $domainExistsService
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
     * @param \Illuminate\Support\Carbon $billingDate
     * @param integer $interval
     * @param integer $intervalCategory
     * @param boolean $isAutoUpdate
     *
     * @throws NotFoundException
     * @throws DomainNotExistsException
     *
     * @return void
     */
    public function handle(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealingRequest
    ): void {
        $userId = Auth::id();

        try {
            if (! $this->clientHasService->isOwner($domainDealingRequest->client_id, $userId)) {
                throw new NotOwnerException();
            }

            if (! $this->domainExistsService->exists($domainDealingRequest->domain_id, $userId)) {
                throw new DomainNotExistsException();
            }

            $this->dealingRepository->store([
                'user_id' => $userId,
                'domain_id' => $domainDealingRequest->domain_id,
                'client_id' => $domainDealingRequest->client_id,
                'subtotal' => $domainDealingRequest->subtotal,
                'discount' => $domainDealingRequest->discount,
                'billing_date' => $domainDealingRequest->billing_date,
                'interval' => $domainDealingRequest->interval,
                'interval_category' => $domainDealingRequest->interval_category,
                'is_auto_update' => $domainDealingRequest->is_auto_update,
            ]);
        } catch (NotOwnerException | DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
