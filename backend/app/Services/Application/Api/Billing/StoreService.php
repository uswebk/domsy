<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Http\Resources\BillingResource;
use App\Models\DomainBilling;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private BillingRepositoryInterface $billingRepository;

    private DomainBilling $billing;

    /**
     * @param BillingRepositoryInterface $billingRepository
     */
    public function __construct(BillingRepositoryInterface $billingRepository)
    {
        $this->billingRepository = $billingRepository;
    }

    /**
     * @param array $attribute
     * @return void
     * @throws Exception
     */
    public function handle(array $attribute): void
    {
        DB::beginTransaction();
        try {
            $this->billing = $this->billingRepository->store($attribute);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @return BillingResource
     */
    public function getResponse(): BillingResource
    {
        return new BillingResource($this->billing);
    }
}
