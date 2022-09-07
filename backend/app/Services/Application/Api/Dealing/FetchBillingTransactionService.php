<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Infrastructures\Models\User;

use Illuminate\Support\Facades\Auth;

final class FetchBillingTransactionService
{
    private $transactionResult;

    const DEFAULT_MONTHS = 12;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Queries\Domain\Billing\EloquentBillingQueryServiceInterface $eloquentBillingQueryService
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Queries\Domain\Billing\EloquentBillingQueryServiceInterface $eloquentBillingQueryService
    ) {
        $backMonths = $request->months ?? self::DEFAULT_MONTHS;

        $user = User::find(Auth::id());
        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->transactionResult = collect([]);

        // TODO: 速度改善(GroupByで集計できるか検討)
        while ($backMonths >= 0) {
            $targetDate = now()->copy()->subMonth($backMonths);
            $targetDateInfo = $targetDate->toArray();

            $billings = $eloquentBillingQueryService->getBillingByUserIdsBillingDateBetweenStartDatetimeEndDatetime(
                $userIds,
                $targetDate->copy()->startOfMonth(),
                $targetDate->copy()->endOfMonth()
            );

            $label = $targetDateInfo['month'] . '/' . $targetDateInfo['year'];

            $totalPrice = 0;
            foreach ($billings as $billing) {
                $totalPrice += $billing->total;
            }

            $this->transactionResult[$label] = $totalPrice;

            $backMonths--;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getResponse(): \Illuminate\Support\Collection
    {
        return $this->transactionResult;
    }
}
