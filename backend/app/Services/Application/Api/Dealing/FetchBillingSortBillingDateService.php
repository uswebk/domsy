<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\BillingResource;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchBillingSortBillingDateService
{
    private $billings;

    private const DEFAULT_TAKE = 5;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Queries\Domain\Billing\EloquentBillingQueryServiceInterface $eloquentBillingQueryService
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Queries\Domain\Billing\EloquentBillingQueryServiceInterface $eloquentBillingQueryService
    ) {
        $take = $request->take ?? self::DEFAULT_TAKE;

        $user = User::find(Auth::id());
        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $this->billings = $eloquentBillingQueryService
        ->getSortBillingDateBillingsByUserIdsBillingDateGreaterThanTargetDatetimeTake(
            $userIds,
            now()->startOfDay(),
            (int)$take
        );
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponse(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return BillingResource::collection($this->billings);
    }
}
