<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\BillingResource;
use Exception;
use Illuminate\Http\Response;

final class BillingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domainBilling')->only(['updateBilling']);
    }

        /**
     * @param \App\Services\Application\Api\Billing\FetchTransactionService $fetchTransactionService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTransaction(
        \App\Services\Application\Api\Billing\FetchTransactionService $fetchTransactionService
    ) {
        return response()->json(
            $fetchTransactionService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Billing\FetchSortBillingDateService $fetchSortBillingDateService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchSortBillingDate(
        \App\Services\Application\Api\Billing\FetchSortBillingDateService $fetchSortBillingDateService
    ) {
        return response()->json(
            $fetchSortBillingDateService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Billing\UpdateRequest $request
     * @param \App\Infrastructures\Models\DomainBilling $domainBilling
     * @param \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Billing\UpdateRequest $request,
        \App\Infrastructures\Models\DomainBilling $domainBilling,
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
    ) {
        $domainBilling->fill($request->makeInput());

        try {
            $domainBilling = $billingRepository->save($domainBilling);

            return response()->json(
                new BillingResource($domainBilling),
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param \App\Http\Requests\Api\Billing\StoreRequest $request
     * @param \App\Services\Application\Api\Billing\StoreService $storeService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Billing\StoreRequest $request,
        \App\Services\Application\Api\Billing\StoreService $storeService
    ) {
        try {
            $storeService->handle($request->makeInput());

            return response()->json(
                $storeService->getResponse(),
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function cancel(
        \App\Infrastructures\Models\DomainBilling $domainBilling
    ) {
    }
}
