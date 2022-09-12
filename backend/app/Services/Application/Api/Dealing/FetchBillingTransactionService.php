<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Infrastructures\Models\User;

use Illuminate\Support\Facades\Auth;

final class FetchBillingTransactionService
{
    private $billingAmounts;

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
        $startMonth = now()->subMonths($backMonths)->startOfMonth();
        $endMonth = now()->copy()->endOfMonth();

        $user = User::find(Auth::id());

        $billingAmounts = $eloquentBillingQueryService->getOfFixedTotalAmountBetweenBillingDateByUserIdsStartDateEndDate(
            $user->getMemberIds(),
            $startMonth,
            $endMonth,
        );

        while ($startMonth->lt($endMonth)) {
            $month = $startMonth->format('Y/m');

            if (isset($billingAmounts[$month])) {
                $this->billingAmounts[$month] = $billingAmounts[$month]['amount'];
            } else {
                $this->billingAmounts[$month] = 0;
            }

            $startMonth->addMonth();
        }
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->billingAmounts;
    }
}
