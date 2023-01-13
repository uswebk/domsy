<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Http\Resources\BillingResource;
use App\Models\DomainBilling;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

final class CancelService
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
     * @param DomainBilling $domainBilling
     * @return void
     * @throws Exception
     */
    public function handle(DomainBilling $domainBilling): void
    {
        DB::beginTransaction();
        try {
            $domainBilling->canceled_at = now();
            $domainBilling->is_fixed = true;

            $this->billing = $this->billingRepository->save($domainBilling);

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
