<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain\Dealing;

use App\Enums\Interval;
use App\Models\DomainDealing;
use Carbon\Carbon;

final class NextBillingDateService
{
    private mixed $billingDate;

    /**
     * @param DomainDealing $domainDealing
     */
    public function __construct(DomainDealing $domainDealing)
    {
        $nextBilling = $domainDealing->getNextBilling();
        $this->billingDate = $nextBilling->billing_date;

        $this->set($domainDealing);
    }

    /**
     * @param DomainDealing $domainDealing
     * @return void
     */
    private function set(DomainDealing $domainDealing): void
    {
        $interval = $domainDealing->interval;
        $category = $domainDealing->interval_category;

        switch ($category) {
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
     * @return Carbon
     */
    public function getNext(): Carbon
    {
        return $this->billingDate;
    }
}
