<?php

declare(strict_types=1);

namespace App\Services\Application;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class DealingStoreService
{
    private $dealingRepository;

    private $billingRepository;

    private $userId;

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
        $domainDealingInput = $domainDealingRequest->getInput();

        DB::beginTransaction();
        try {
            $domainDealing = $this->dealingRepository->store([
                'user_id' => $this->userId,
                'domain_id' => $domainDealingInput->domain_id,
                'client_id' => $domainDealingInput->client_id,
                'subtotal' => $domainDealingInput->subtotal,
                'discount' => $domainDealingInput->discount,
                'billing_date' => $domainDealingInput->billing_date,
                'interval' => $domainDealingInput->interval,
                'interval_category' => $domainDealingInput->interval_category,
                'is_auto_update' => $domainDealingInput->is_auto_update,
                'is_halt' => $domainDealingInput->is_halt,
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

            report($e);

            throw $e;
        }
    }
}
