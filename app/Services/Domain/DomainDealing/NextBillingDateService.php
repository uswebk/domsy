<?php

declare(strict_types=1);

namespace App\Services\Domain\DomainDealing;

use App\Enums\Interval;

final class NextBillingDateService
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return \Carbon\Carbon
     */
    public function get(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): \Carbon\Carbon {
        $targetDate = $domainDealing->billing_date;
        $interval = $domainDealing->interval;
        $intervalCategory = $domainDealing->interval_category;

        if ($intervalCategory === Interval::DAY->name) {
            return $targetDate->addDays($interval);
        }

        if ($intervalCategory === Interval::WEEK->name) {
            return $targetDate->addWeeks($interval);
        }

        if ($intervalCategory === Interval::MONTH->name) {
            return $targetDate->addMonths($interval);
        }

        if ($intervalCategory === Interval::YEAR->name) {
            return $targetDate->addYears($interval);
        }
    }
}
