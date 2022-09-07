<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchTransactionService
{
    private $transactionResult;

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

        $user = User::find(Auth::id());
        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->transactionResult = collect([]);

        while ($backMonths >= 0) {
            $targetDate = now()->copy()->subMonth($backMonths);
            $targetDateInfo = $targetDate->toArray();

            $domains = $eloquentDomainQueryService->getActiveByUserIdsPurchasedAtLessThanTargetDatetime(
                $userIds,
                $targetDate->copy()->endOfMonth()
            );

            $label = $targetDateInfo['month'] . '/' . $targetDateInfo['year'];
            $this->transactionResult[$label] = $domains->count();

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
