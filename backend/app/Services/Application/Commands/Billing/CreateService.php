<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Billing;

use App\Models\DomainBilling;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use App\Services\Domain\Domain\Dealing\NextBillingDateService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

final class CreateService
{
    private BillingRepositoryInterface $billingRepository;

    private const CHUNK_SIZE = 1000;

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
     */
    private function executeOfDomainBilling(DomainBilling $domainBilling): void
    {
        $domainDealing = $domainBilling->domainDealing;

        $this->billingRepository->firstOrCreate([
            'dealing_id' => $domainDealing->id,
            'total' => $domainDealing->getBillingAmount(),
            'billing_date' => (new NextBillingDateService($domainDealing))->getNext(),
            'is_auto' => true,
            'is_fixed' => false,
        ]);

        $this->billingRepository->updateIsFixed($domainBilling, true);
    }

    /**
     * @param Carbon $executeDate
     * @return void
     */
    public function handle(Carbon $executeDate): void
    {
        DomainBilling::join('domain_dealings', 'domain_billings.dealing_id', '=', 'domain_dealings.id')
            ->where('domain_dealings.is_auto_update', '=', true)
            ->where('domain_dealings.is_halt', '=', false)
            ->where('domain_billings.is_fixed', '=', false)
            ->where('domain_billings.billing_date', '=', $executeDate->toDateTimeString())
            ->select('domain_billings.*')
            ->chunk(self::CHUNK_SIZE, function (
                \Illuminate\Database\Eloquent\Collection $domainBillings
            ) {
                foreach ($domainBillings as $domainBilling) {
                    DB::beginTransaction();
                    try {
                        $this->executeOfDomainBilling($domainBilling);

                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollBack();

                        throw $e;
                    }
                }
            });
    }
}
