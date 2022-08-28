<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\BillingResource;
use App\Http\Resources\DomainDealingResource;
use Illuminate\Http\Response;

final class DealingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domainBilling')->only(['updateBilling']);
        $this->middleware('can:owner,domainDealing')->only(['fetchId']);
    }

    /**
     * @param \App\Services\Application\DealingFetchService $dealingFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\DealingFetchService $dealingFetchService
    ) {
        return response()->json(
            $dealingFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetchId(
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ) {
        return response()->json(
            new DomainDealingResource($domainDealing),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\DealingFetchBillingTransactionService $dealingFetchBillingTransactionService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetchBillingTransaction(
        \App\Services\Application\DealingFetchBillingTransactionService $dealingFetchBillingTransactionService
    ) {
        return response()->json(
            $dealingFetchBillingTransactionService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\DealingFetchBillingSortBillingDateService $dealingFetchBillingSortBillingDateService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetchBillingSortBillingDate(
        \App\Services\Application\DealingFetchBillingSortBillingDateService $dealingFetchBillingSortBillingDateService
    ) {
        return response()->json(
            $dealingFetchBillingSortBillingDateService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Dealing\UpdateRequest $request
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @param \App\Services\Application\DealingUpdateService $dealingUpdateService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Dealing\UpdateRequest $request,
        \App\Infrastructures\Models\DomainDealing $domainDealing,
        \App\Services\Application\DealingUpdateService $dealingUpdateService
    ) {
        $domainDealingRequest = $request->makeInput();
        $dealingUpdateService->handle($domainDealingRequest, $domainDealing);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Dealing\StoreRequest $request
     * @param \App\Services\Application\DealingStoreService $dealingStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Dealing\StoreRequest $request,
        \App\Services\Application\DealingStoreService $dealingStoreService
    ) {
        $domainDealingRequest = $request->makeInput();
        $dealingStoreService->handle($domainDealingRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * NOTE: Role Dummy
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function detail()
    {
        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Dealing\BillingUpdateRequest $request
     * @param \App\Infrastructures\Models\DomainBilling $domainBilling
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function updateBilling(
        \App\Http\Requests\Api\Dealing\BillingUpdateRequest $request,
        \App\Infrastructures\Models\DomainBilling $domainBilling,
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
    ) {
        $domainDealingRequest = $request->makeInput();

        $domainBilling->fill($domainDealingRequest);

        $domainBilling = $billingRepository->save($domainBilling);

        return response()->json(
            new BillingResource($domainBilling),
            Response::HTTP_OK
        );
    }
}
