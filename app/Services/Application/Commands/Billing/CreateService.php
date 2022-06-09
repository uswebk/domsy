<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Billing;

use App\Helpers\DateHelper;
use App\Infrastructures\Models\Eloquent\DomainBilling;
use App\Infrastructures\Models\Interval;

final class CreateService
{
    private $billingRepository;

    private const CHUNK_SIZE = 1000;

    public function __construct(
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
    ) {
        $this->billingRepository = $billingRepository;
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainBilling $domainBilling
     * @param \Carbon\Carbon $executeDate
     * @return void
     */
    private function executeOfDomainBilling(
        \App\Infrastructures\Models\Eloquent\DomainBilling $domainBilling,
        \Carbon\Carbon $executeDate
    ): void {
        $domainDealing = $domainBilling->domainDealing;

        $nextBillingDate = Interval::getDateByIntervalIntervalCategory(
            $executeDate,
            $domainDealing->interval,
            $domainDealing->interval_category
        );

        $this->billingRepository->store([
            'dealing_id' => $domainDealing->id,
            'total' => $domainDealing->getBillingAmount(),
            'billing_date' => $nextBillingDate,
            'is_fixed' => false,

        ]);

        $this->billingRepository->updateIsFixed($domainBilling, true);
    }

    /**
     * @param \Carbon\Carbon $executeDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getQueryBuilderOfDomainBilling(
        \Carbon\Carbon $executeDate
    ): \Illuminate\Database\Eloquent\Builder {
        $datetimeStartString = DateHelper::getDatetimeStartString($executeDate);

        return DomainBilling::join('domain_dealings', 'domain_billings.dealing_id', '=', 'domain_dealings.id')
        ->where('domain_dealings.is_auto_update', '=', true)
        ->where('domain_dealings.is_halt', '=', false)
        ->where('domain_billings.billing_date', '=', $datetimeStartString);
    }

    /**
     * @param \Carbon\Carbon $executeDate
     * @return void
     */
    public function handle(\Carbon\Carbon $executeDate): void
    {
        $query = $this->getQueryBuilderOfDomainBilling($executeDate);

        $query->chunk(self::CHUNK_SIZE, function (
            \Illuminate\Database\Eloquent\Collection $domainBillings
        ) use ($executeDate) {
            foreach ($domainBillings as $domainBilling) {
                $this->executeOfDomainBilling($domainBilling, $executeDate);
            }
        });
    }
}
