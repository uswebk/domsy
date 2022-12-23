<?php

declare(strict_types=1);

namespace App\Queries\Domain\Billing;

use App\Models\DomainBilling;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentBillingQueryService implements EloquentBillingQueryServiceInterface
{
    /**
     * @param array $userIds
     * @param Carbon $targetDatetime
     * @return Collection
     */
    public function getValidUnclaimed(array $userIds, Carbon $targetDatetime): Collection
    {
        return DomainBilling::join('domain_dealings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
            ->join('domains', 'domains.id', '=', 'domain_dealings.domain_id')
            ->select('domain_billings.*')
            ->whereIn('domains.user_id', $userIds)
            ->where('domain_billings.is_fixed', false)
            ->whereNull('domain_billings.canceled_at')
            ->where('domain_billings.billing_date', '>=', $targetDatetime)
            ->get();
    }

    /**
     * @param array $userIds
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return \Illuminate\Support\Collection
     */
    public function getFixedTotalAmountOfDuringPeriod(
        array $userIds,
        Carbon $startDate,
        Carbon $endDate
    ): \Illuminate\Support\Collection {
        return DomainBilling::select([
            DB::raw('DATE_FORMAT(domain_billings.billing_date,\'%Y/%m\') AS month'),
            DB::raw('SUM(domain_billings.total) AS amount'),
        ])
            ->join('domain_dealings', 'domain_dealings.id', '=', 'domain_billings.dealing_id')
            ->join('domains', 'domains.id', '=', 'domain_dealings.domain_id')
            ->whereIn('domains.user_id', $userIds)
            ->where('domain_billings.is_fixed', true)
            ->groupBy('month')
            ->whereBetween('domain_billings.billing_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereNull('domain_billings.canceled_at')
            ->get();
    }
}
