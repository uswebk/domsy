<?php

declare(strict_types=1);

namespace App\Queries\Domain;

interface DomainQueryServiceInterface
{
    /**
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserIds(array $userIds): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param array $userIds
     * @param \Carbon\Carbon $targetDatetime
     * @param integer $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt(
        array $userIds,
        \Carbon\Carbon $targetDatetime,
        int $count
    ): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param array $userIds
     * @return \App\Models\Domain
     */
    public function getActiveCountByUserIds(array $userIds): \App\Models\Domain;

    /**
     * @param array $userIds
     * @return int
     */
    public function getSumOfFixedBillingPriceByUserIds(array $userIds): int;

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
    ): array;
}
