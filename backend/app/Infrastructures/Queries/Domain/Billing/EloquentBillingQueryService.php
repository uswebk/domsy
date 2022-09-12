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

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return array
     */
    public function getOfFixedTotalAmountBetweenBillingDateByUserIdsStartDateEndDate(
        array $userIds,
        \Carbon\Carbon $startDate,
        \Carbon\Carbon $endDate
    ): array {
        return DomainBilling::select([
            \Illuminate\Support\Facades\DB::raw('DATE_FORMAT(domain_billings.billing_date,\'%Y/%m\') AS month'),
            \Illuminate\Support\Facades\DB::raw('SUM(domain_billings.total) AS amount'),
        ])
        ->join('domain_dealings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
        ->join('domains', 'domains.id', '=', 'domain_dealings.domain_id')
        ->whereIn('domains.user_id', $userIds)
        ->where('domain_billings.is_fixed', true)
        ->groupBy('month')
        ->whereBetween('domain_billings.billing_date', [$startDate->toDateString(), $endDate->toDateString()])
        ->get()
        ->keyBy('month')
        ->toArray();
    }
}
