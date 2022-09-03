<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain\Billing;

interface EloquentBillingQueryServiceInterface
{
    /**
     * @param array $userIds
     * @param \Carbon\Carbon $startDatetime
     * @param \Carbon\Carbon $endDatetime
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBillingByUserIdsBillingDateBetweenStartDatetimeEndDatetime(
        array $userIds,
        \Carbon\Carbon $startDatetime,
        \Carbon\Carbon $endDatetime
    ): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $targetDatetime
     * @param integer $take
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSortBillingDateBillingsByUserIdsBillingDateGreaterThanTargetDatetimeTake(
        array $userIds,
        \Carbon\Carbon $targetDatetime,
        int $take
    ): \Illuminate\Database\Eloquent\Collection;
}
