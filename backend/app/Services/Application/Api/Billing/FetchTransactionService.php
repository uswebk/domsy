<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Models\User;
use App\Queries\Domain\Billing\EloquentBillingQueryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class FetchTransactionService
{
    private array $billingAmounts;

    const DEFAULT_MONTHS = 12;

    /**
     * @param Request $request
     * @param EloquentBillingQueryServiceInterface $eloquentBillingQueryService
     */
    public function __construct(
        Request $request,
        EloquentBillingQueryServiceInterface $eloquentBillingQueryService
    ) {
        $backMonths = $request->months ?? self::DEFAULT_MONTHS;

        $startMonth = now()->subMonths($backMonths)->startOfMonth();
        $endMonth = now()->copy()->endOfMonth();

        $user = User::find(Auth::id());

        $billings = $eloquentBillingQueryService->getFixedTotalAmountOfDuringPeriod(
            $user->getMemberIds(),
            $startMonth,
            $endMonth,
        );

        $billingAmounts = $billings->keyBy('month')->toArray();

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
