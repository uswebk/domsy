<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Domain;

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
}
