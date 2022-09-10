<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Domain;
use Illuminate\Support\Facades\DB;

final class EloquentDomainQueryService implements EloquentDomainQueryServiceInterface
{
    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Domain
    {
        return Domain::where('id', $id)->where('user_id', $userId)
        ->firstOrFail();
    }

    /**
     * @param integer $userId
     * @param string $name
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByUserIdName(int $userId, string $name): \App\Infrastructures\Models\Domain
    {
        return Domain::where('name', $name)->where('user_id', $userId)
        ->firstOrFail();
    }

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection
    {
        return Domain::whereIn('user_id', $userIds)->get();
    }

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $targetDatetime
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveByUserIdsPurchasedAtLessThanTargetDatetime(
        array $userIds,
        \Carbon\Carbon $targetDatetime
    ): \Illuminate\Database\Eloquent\Collection {
        return Domain::whereIn('user_id', $userIds)
        ->where('is_active', true)
        ->where('is_transferred', false)
        ->whereNull('canceled_at')
        ->where('purchased_at', '<=', $targetDatetime)
        ->get();
    }

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
        return Domain::join('domain_dealings', 'domains.id', '=', 'domain_dealings.domain_id')
        ->join('domain_billings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
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
    public function getSortExpiredByUserIdsExpiredGreaterThanTargetDatetimeTake(
        array $userIds,
        \Carbon\Carbon $targetDatetime,
        int $take
    ): \Illuminate\Database\Eloquent\Collection {
        return Domain::whereIn('user_id', $userIds)
        ->where('is_active', true)
        ->where('is_transferred', false)
        ->whereNull('canceled_at')
        ->where('expired_at', '>=', $targetDatetime)
        ->orderBy('expired_at')
        ->take($take)
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
        return Domain::join('domain_dealings', 'domains.id', '=', 'domain_dealings.domain_id')
        ->join('domain_billings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
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
     * @return \App\Infrastructures\Models\Domain
     */
    public function getAggregatedActiveCountByUserIds(array $userIds): \App\Infrastructures\Models\Domain
    {
        return Domain::select([
            DB::raw('COUNT(*) AS total'),
            DB::raw('COUNT(CASE WHEN is_active = 1 THEN 1 END) AS active'),
            DB::raw('COUNT(CASE WHEN is_active = 0 THEN 0 END) AS inactive'),
        ])
        ->whereIn('user_id', $userIds)
        ->first();
    }

    /**
     * @param array $userIds
     * @param boolean $isFixed
     * @return void
     */
    public function getAggregatedBillingTotalPriceByUserIdsIsFixed(array $userIds, bool $isFixed): int
    {
        return (int) Domain::join('domain_dealings', 'domains.id', '=', 'domain_dealings.domain_id')
        ->join('domain_billings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
        ->where('domain_billings.is_fixed', $isFixed)
        ->whereIn('domains.user_id', $userIds)
        ->sum('domain_billings.total');
    }

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return array
     */
    public function getCountOfActiveDomainBetweenPurchasedAtByUserIdsStartDateEndDate(
        array $userIds,
        \Carbon\Carbon $startDate,
        \Carbon\Carbon $endDate
    ):array {
        return Domain::select([
            DB::raw('DATE_FORMAT(purchased_at,\'%Y/%m\') AS month'),
            DB::raw('COUNT(*) AS count'),
        ])
        ->whereIn('user_id', $userIds)
        ->where('is_active', true)
        ->where('is_transferred', false)
        ->whereNull('canceled_at')
        ->groupBy('month')
        ->whereBetween('purchased_at', [$startDate->toDateString(), $endDate->toDateString()])
        ->get()
        ->keyBy('month')
        ->toArray();
    }
}
