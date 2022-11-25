<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Domain;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentDomainQueryService implements EloquentDomainQueryServiceInterface
{
    /**
     * @param array $userIds
     * @return Collection
     */
    public function getByUserIds(array $userIds): Collection
    {
        return Domain::whereIn('user_id', $userIds)->get();
    }

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $targetDatetime
     * @param integer $count
     * @return Collection
     */
    public function getActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt(
        array $userIds,
        \Carbon\Carbon $targetDatetime,
        int $count
    ): Collection {
        return Domain::whereIn('user_id', $userIds)
            ->where('is_active', true)
            ->where('is_transferred', false)
            ->whereNull('canceled_at')
            ->where('expired_at', '>=', $targetDatetime)
            ->orderBy('expired_at')
            ->take($count)
            ->get();
    }

    /**
     * @param array $userIds
     * @return Domain
     */
    public function getActiveCountByUserIds(array $userIds): Domain
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
     * @return int
     */
    public function getSumOfFixedBillingPriceByUserIds(array $userIds): int
    {
        return (int) Domain::join('domain_dealings', 'domains.id', '=', 'domain_dealings.domain_id')
            ->join('domain_billings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
            ->where('domain_billings.is_fixed', true)
            ->whereIn('domains.user_id', $userIds)
            ->whereNull('domain_billings.canceled_at')
            ->sum('domain_billings.total');
    }

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return array
     */
    public function getCountOfActiveByUserIdsBetweenPurchasedAt(
        array $userIds,
        \Carbon\Carbon $startDate,
        \Carbon\Carbon $endDate
    ): array {
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
