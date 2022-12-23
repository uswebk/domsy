<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Billing;

use App\Http\Resources\BillingResource;
use App\Models\User;
use App\Queries\Domain\Billing\EloquentBillingQueryServiceInterface;
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
     * @param EloquentBillingQueryServiceInterface $eloquentBillingQueryService
     */
    public function __construct(
        Request $request,
        EloquentBillingQueryServiceInterface $eloquentBillingQueryService
    ) {
        $take = $request->take ?? self::DEFAULT_TAKE;

        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        $billings = $eloquentBillingQueryService->getValidUnclaimed($userIds, now()->startOfDay());

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
