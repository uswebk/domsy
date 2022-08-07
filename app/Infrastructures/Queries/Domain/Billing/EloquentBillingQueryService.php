<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain\Billing;

use App\Infrastructures\Models\DomainBilling;

final class EloquentBillingQueryService implements EloquentBillingQueryServiceInterface
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
    ): \Illuminate\Database\Eloquent\Collection {
        return DomainBilling::join('domain_dealings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
        ->join('domains', 'domains.id', '=', 'domain_dealings.domain_id')
        ->select('domain_billings.*')
        ->whereIn('domains.user_id', $userIds)
        ->whereBetween('domain_billings.billing_date', [$startDatetime, $endDatetime])
        ->get();
    }

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
    ): \Illuminate\Database\Eloquent\Collection {
        return DomainBilling::join('domain_dealings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
        ->join('domains', 'domains.id', '=', 'domain_dealings.domain_id')
        ->select('domain_billings.*')
        ->whereIn('domains.user_id', $userIds)
        ->where('domain_billings.is_fixed', false)
        ->where('domain_billings.billing_date', '>=', $targetDatetime)
        ->orderBy('domain_billings.billing_date')
        ->take($take)
        ->get();
    }
}
