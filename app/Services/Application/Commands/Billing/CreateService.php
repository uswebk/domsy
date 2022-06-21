<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Billing;

use App\Helpers\DateHelper;
use App\Infrastructures\Models\DomainBilling;

use Exception;

use Illuminate\Support\Facades\DB;

final class CreateService
{
    private $executeDate;

    private $billingRepository;

    private const CHUNK_SIZE = 1000;

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
    private function executeOfDomainBilling(
        \App\Infrastructures\Models\DomainBilling $domainBilling
    ): void {
        $domainDealing = $domainBilling->domainDealing;

        $this->billingRepository->firstOrCreate([
            'dealing_id' => $domainDealing->id,
            'total' => $domainDealing->getBillingAmount(),
            'billing_date' => $domainDealing->getNextBillingDateByTargetDate($this->executeDate),
            'is_fixed' => false,
        ]);

        $this->billingRepository->updateIsFixed($domainBilling, true);
    }

    /**
     * @return \Illuminate\Database\Builder
     */
    private function getQueryBuilderOfDomainBilling(): \Illuminate\Database\Builder
    {
        $datetimeStartString = DateHelper::getDatetimeStartString($this->executeDate);

        return DomainBilling::join('domain_dealings', 'domain_billings.dealing_id', '=', 'domain_dealings.id')
        ->where('domain_dealings.is_auto_update', '=', true)
        ->where('domain_dealings.is_halt', '=', false)
        ->where('domain_billings.billing_date', '=', $datetimeStartString)
        ->select('domain_billings.*');
    }

    /**
     * @param \Carbon\Carbon $executeDate
     * @return void
     */
    public function handle(\Carbon\Carbon $executeDate): void
    {
        $this->executeDate = $executeDate;

        $query = $this->getQueryBuilderOfDomainBilling();

        $query->chunk(self::CHUNK_SIZE, function (
            \Illuminate\Database\Collection $domainBillings
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
