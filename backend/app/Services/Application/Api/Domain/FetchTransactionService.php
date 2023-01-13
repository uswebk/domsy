<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Requests\Request;
use App\Models\User;
use App\Queries\Domain\DomainQueryServiceInterface;
use Illuminate\Support\Facades\Auth;

final class FetchTransactionService
{
    private array $countOfDomains = [];

    const DEFAULT_MONTHS = 6;

    /**
     * @param Request $request
     * @param DomainQueryServiceInterface $domainQueryService
     */
    public function __construct(Request $request, DomainQueryServiceInterface $domainQueryService)
    {
        $backMonths = $request->months ?? self::DEFAULT_MONTHS;
        $startMonth = now()->subMonths($backMonths)->startOfMonth();
        $endMonth = now()->copy()->endOfMonth();

        $user = User::find(Auth::id());

        $countOfDomains = $domainQueryService->getCountOfActiveByUserIdsBetweenPurchasedAt(
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
