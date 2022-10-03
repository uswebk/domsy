<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Http\Resources\BillingResource;
use Exception;
use Illuminate\Support\Facades\DB;

final class StoreService
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
     * @param array $attribute
     * @return void
     */
    public function handle(array $attribute): void
    {
        DB::beginTransaction();
        try {
            $this->billing = $this->billingRepository->store([
                'dealing_id' => $attribute['dealing_id'],
                'total' => $attribute['total'],
                'billing_date' => $attribute['billing_date'],
                'is_fixed' => $attribute['is_fixed'],
                'is_auto' => $attribute['is_auto'],
                'changed_at' => null,
            ]);

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
