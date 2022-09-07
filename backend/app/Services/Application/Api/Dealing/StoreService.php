<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private $dealingRepository;

    private $billingRepository;

    private $userId;

    private $dealing;

    /**
     * @param \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository
     * @param \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository,
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->billingRepository = $billingRepository;

        $this->userId = Auth::id();
    }

    /**
     * @param \App\Services\Application\InputData\DealingStoreRequest $domainDealingRequest
     *
     * @return void
    */
    public function handle(
        \App\Services\Application\InputData\DealingStoreRequest $domainDealingRequest
    ): void {
        $dealingInput = $domainDealingRequest->getInput();

        DB::beginTransaction();
        try {
            $this->dealing = $this->dealingRepository->store([
                'user_id' => $this->userId,
                'domain_id' => $dealingInput->domain_id,
                'client_id' => $dealingInput->client_id,
                'subtotal' => $dealingInput->subtotal,
                'discount' => $dealingInput->discount,
                'billing_date' => $dealingInput->billing_date,
                'interval' => $dealingInput->interval,
                'interval_category' => $dealingInput->interval_category,
                'is_auto_update' => $dealingInput->is_auto_update,
                'is_halt' => $dealingInput->is_halt,
            ]);

            $this->billingRepository->store([
                'dealing_id' => $this->dealing->id,
                'total' => $this->dealing->getBillingAmount(),
                'billing_date' => $this->dealing->getNextBillingDate(),
                'is_fixed' => false,
                'changed_at' => null,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            report($e);

            throw $e;
        }
    }

    /**
     * @return \App\Http\Resources\DomainDealingResource
     */
    public function getResponse(): \App\Http\Resources\DomainDealingResource
    {
        return new DomainDealingResource($this->dealing);
    }
}
