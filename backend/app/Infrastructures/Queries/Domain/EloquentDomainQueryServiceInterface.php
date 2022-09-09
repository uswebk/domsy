<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Domain;

interface EloquentDomainQueryServiceInterface
{
    /**
     * @param integer $id
     * @param integer $userId
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByIdUserId(int $id, int $userId): \App\Infrastructures\Models\Domain;

    /**
     * @param integer $userId
     * @param string $name
     * @return \App\Infrastructures\Models\Domain
     */
    public function getFirstByUserIdName(int $userId, string $name): \App\Infrastructures\Models\Domain;

    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $targetDatetime
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveByUserIdsPurchasedAtLessThanTargetDatetime(
        array $userIds,
        \Carbon\Carbon $targetDatetime
    ): \Illuminate\Database\Eloquent\Collection;

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
    public function getSortExpiredByUserIdsExpiredGreaterThanTargetDatetimeTake(
        array $userIds,
        \Carbon\Carbon $targetDatetime,
        int $take
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

    /**
     * @param array $userIds
     * @return \App\Infrastructures\Models\Domain
     */
    public function getAggregatedActiveCountByUserIds(array $userIds): \App\Infrastructures\Models\Domain;
}
