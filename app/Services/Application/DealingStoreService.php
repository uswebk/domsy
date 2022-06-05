<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\DomainNotExistsException;
use App\Exceptions\Client\NotOwnerException;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DealingStoreService
{
    private $dealingRepository;

    private $billingRepository;

    private $clientHasService;

    private $domainExistsService;

    private $userId;

    /**
     * @param \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository
     * @param \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
     * @param \App\Services\Domain\Client\HasService $clientHasService
     * @param \App\Services\Domain\Domain\ExistsService $domainExistsService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository,
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository,
        \App\Services\Domain\Client\HasService $clientHasService,
        \App\Services\Domain\Domain\ExistsService $domainExistsService
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->billingRepository = $billingRepository;
        $this->clientHasService = $clientHasService;
        $this->domainExistsService = $domainExistsService;

        $this->userId = Auth::id();
    }

    /**
      * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealingRequest
      *
      * @throws NotFoundException
      * @throws DomainNotExistsException
      *
      * @return void
      */
    public function handle(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealingRequest
    ): void {
        try {
            if (! $this->clientHasService->isOwner($domainDealingRequest->client_id, $this->userId)) {
                throw new NotOwnerException();
            }

            if (! $this->domainExistsService->exists($domainDealingRequest->domain_id, $this->userId)) {
                throw new DomainNotExistsException();
            }
        } catch (NotOwnerException | DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        }

        DB::beginTransaction();
        try {
            $domainDealing = $this->dealingRepository->store([
                'user_id' => $this->userId,
                'domain_id' => $domainDealingRequest->domain_id,
                'client_id' => $domainDealingRequest->client_id,
                'subtotal' => $domainDealingRequest->subtotal,
                'discount' => $domainDealingRequest->discount,
                'billing_date' => $domainDealingRequest->billing_date,
                'interval' => $domainDealingRequest->interval,
                'interval_category' => $domainDealingRequest->interval_category,
                'is_auto_update' => $domainDealingRequest->is_auto_update,
            ]);

            $this->billingRepository->store([
                'dealing_id' => $domainDealing->id,
                'total' => $domainDealing->getBillingAmount(),
                'billing_date' => $domainDealing->getNextBillingDate(),
                'is_fixed' => false,
                'changed_at' => null,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
