<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain\Dealing;

use App\Enums\Interval;

final class NextBillingDateService
{
    private $billingDate;

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     */
    public function __construct(
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ) {
        $nextBilling = $domainDealing->getNextBilling();
        $this->billingDate = $nextBilling->billing_date;

        $this->set($domainDealing);
    }

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return void
     */
    private function set(\App\Infrastructures\Models\DomainDealing $domainDealing): void
    {
        $interval = $domainDealing->interval;
        $category = $domainDealing->interval_category;

        switch($category) {
            case Interval::DAY->name:
                $this->billingDate->addDays($interval);
                break;
            case Interval::WEEK->name:
                $this->billingDate->addWeeks($interval);
                break;
            case Interval::MONTH->name:
                $this->billingDate->addMonths($interval);
                break;
            case Interval::YEAR->name:
                $this->billingDate->addYears($interval);
                break;
        }
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getNext(): \Carbon\Carbon
    {
        return $this->billingDate;
    }
}
