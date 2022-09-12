<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchTransactionService
{
    private $countOfDomains;

    const DEFAULT_MONTHS = 6;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $backMonths = $request->months ?? self::DEFAULT_MONTHS;
        $startMonth = now()->subMonths($backMonths)->startOfMonth();
        $endMonth = now()->copy()->endOfMonth();

        $user = User::find(Auth::id());

        $countOfDomains = $eloquentDomainQueryService->getCountOfActiveDomainBetweenPurchasedAtByUserIdsStartDateEndDate(
            $user->getMemberIds(),
            $startMonth,
            $endMonth,
        );

        while ($startMonth->lt($endMonth)) {
            $month = $startMonth->format('Y/m');

            if (isset($countOfDomains[$month])) {
                $this->countOfDomains[$month] = $countOfDomains[$month]['count'];
            } else {
                $this->countOfDomains[$month] = 0;
            }

            $startMonth->addMonth();
        }
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->countOfDomains;
    }
}
