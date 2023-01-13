<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Http\Resources\BillingResource;
use App\Models\User;
use App\Queries\Domain\Billing\BillingQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchSortBillingDateService
{
    private Collection $billings;

    private const DEFAULT_TAKE = 5;

    /**
     * @param Request $request
     * @param BillingQueryServiceInterface $billingQueryService
     */
    public function __construct(Request $request, BillingQueryServiceInterface $billingQueryService)
    {
        $take = $request->take ?? self::DEFAULT_TAKE;

        $user = User::find(Auth::id());

        $userIds = ($user->isCompany()) ? $user->getMemberIds() : [$user->id];

        $billings = $billingQueryService->getValidUnclaimed($userIds, now()->startOfDay());

        $this->billings = $billings->sortBy('billing_date')->take($take);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return BillingResource::collection($this->billings);
    }
}
