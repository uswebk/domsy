<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use App\Models\DomainDealing;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use App\Repositories\Domain\Dealing\DealingRepositoryInterface;
use App\Services\Application\InputData\DealingStoreRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private DealingRepositoryInterface $dealingRepository;

    private BillingRepositoryInterface $billingRepository;

    private $userId;

    private DomainDealing $dealing;

    /**
     * @param DealingRepositoryInterface $dealingRepository
     * @param BillingRepositoryInterface $billingRepository
     */
    public function __construct(
        DealingRepositoryInterface $dealingRepository,
        BillingRepositoryInterface $billingRepository
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->billingRepository = $billingRepository;

        $this->userId = Auth::id();
    }

    /**
     * @param DealingStoreRequest $domainDealingRequest
     * @return void
     * @throws Exception
     */
    public function handle(
        DealingStoreRequest $domainDealingRequest
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
                'billing_date' => $this->dealing->billing_date,
                'is_fixed' => false,
                'changed_at' => null,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * @return DomainDealingResource
     */
    public function getResponse(): DomainDealingResource
    {
        return new DomainDealingResource($this->dealing);
    }
}
