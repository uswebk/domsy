<?php

declare(strict_types=1);

namespace App\Queries\Domain\Billing;

interface BillingQueryServiceInterface
{
    /**
     * @param array $userIds
     * @param \Carbon\Carbon $targetDatetime
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getValidUnclaimed(
        array $userIds,
        \Carbon\Carbon $targetDatetime,
    ): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return \Illuminate\Support\Collection
     */
    public function getFixedTotalAmountOfDuringPeriod(
        array $userIds,
        \Carbon\Carbon $startDate,
        \Carbon\Carbon $endDate
    ): \Illuminate\Support\Collection;
}
