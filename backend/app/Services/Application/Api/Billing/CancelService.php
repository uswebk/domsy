<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Http\Resources\BillingResource;
use Exception;
use Illuminate\Support\Facades\DB;

final class CancelService
{
    private $billingRepository;

    private $billing;

    /**
     * @param \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
    ) {
        $this->billingRepository = $billingRepository;
    }

    /**
     * @param \App\Infrastructures\Models\DomainBilling $domainBilling
     * @return void
     */
    public function handle(\App\Infrastructures\Models\DomainBilling $domainBilling): void
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
     * @return \App\Http\Resources\BillingResource
     */
    public function getResponse(): \App\Http\Resources\BillingResource
    {
        return new BillingResource($this->billing);
    }
}
