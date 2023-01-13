<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Billing\StoreRequest;
use App\Http\Requests\Api\Billing\UpdateRequest;
use App\Http\Resources\BillingResource;
use App\Models\DomainBilling;
use App\Repositories\Domain\Billing\BillingRepositoryInterface;
use App\Services\Application\Api\Billing\CancelService;
use App\Services\Application\Api\Billing\FetchSortBillingDateService;
use App\Services\Application\Api\Billing\FetchTransactionService;
use App\Services\Application\Api\Billing\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class BillingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domainBilling')->only(['update', 'cancel']);
    }

    /**
     * @param FetchTransactionService $fetchTransactionService
     * @return JsonResponse
     */
    public function fetchTransaction(FetchTransactionService $fetchTransactionService): JsonResponse
    {
        return response()->json(
            $fetchTransactionService->getResponse(),
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * @param FetchSortBillingDateService $fetchSortBillingDateService
     * @return JsonResponse
     */
    public function fetchSortBillingDate(FetchSortBillingDateService $fetchSortBillingDateService): JsonResponse
    {
        return response()->json(
            $fetchSortBillingDateService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param UpdateRequest $request
     * @param DomainBilling $domainBilling
     * @param BillingRepositoryInterface $billingRepository
     * @return JsonResponse
     */
    public function update(
        UpdateRequest $request,
        DomainBilling $domainBilling,
        BillingRepositoryInterface $billingRepository
    ): JsonResponse {
        $domainBilling->fill($request->makeInput());

        try {
            $domainBilling = $billingRepository->save($domainBilling);

            return response()->json(
                new BillingResource($domainBilling),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param StoreRequest $request
     * @param StoreService $storeService
     * @return JsonResponse
     */
    public function store(StoreRequest $request, StoreService $storeService): JsonResponse
    {
        try {
            $storeService->handle($request->makeInput());

            return response()->json(
                $storeService->getResponse(),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param DomainBilling $domainBilling
     * @param CancelService $cancelService
     * @return JsonResponse
     */
    public function cancel(DomainBilling $domainBilling, CancelService $cancelService): JsonResponse
    {
        try {
            $cancelService->handle($domainBilling);

            return response()->json(
                $cancelService->getResponse(),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
