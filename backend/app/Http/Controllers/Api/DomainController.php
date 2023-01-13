<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Domain\StoreRequest;
use App\Http\Requests\Api\Domain\UpdateRequest;
use App\Models\Domain;
use App\Repositories\Domain\DomainRepositoryInterface;
use App\Services\Application\Api\Domain\FetchActiveSummaryService;
use App\Services\Application\Api\Domain\FetchService;
use App\Services\Application\Api\Domain\FetchSortExpiredService;
use App\Services\Application\Api\Domain\FetchTotalSellerService;
use App\Services\Application\Api\Domain\FetchTransactionService;
use App\Services\Application\Api\Domain\StoreService;
use App\Services\Application\Api\Domain\UpdateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DomainController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domain')->except([
            'fetch',
            'fetchTotalSeller',
            'fetchTransition',
            'fetchSortExpired',
            'fetchActiveSummary',
            'store',
        ]);
    }

    /**
     * @param FetchService $fetchService
     * @return JsonResponse
     */
    public function fetch(FetchService $fetchService): JsonResponse
    {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param FetchTotalSellerService $fetchTotalSellerService
     * @return JsonResponse
     */
    public function fetchTotalSeller(FetchTotalSellerService $fetchTotalSellerService): JsonResponse
    {
        return response()->json(
            $fetchTotalSellerService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param FetchTransactionService $fetchTransactionService
     * @return JsonResponse
     */
    public function fetchTransition(FetchTransactionService $fetchTransactionService): JsonResponse
    {
        return response()->json(
            $fetchTransactionService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param FetchSortExpiredService $fetchSortExpiredService
     * @return JsonResponse
     */
    public function fetchSortExpired(FetchSortExpiredService $fetchSortExpiredService): JsonResponse
    {
        return response()->json(
            $fetchSortExpiredService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param FetchActiveSummaryService $fetchActiveSummaryService
     * @return JsonResponse
     */
    public function fetchActiveSummary(FetchActiveSummaryService $fetchActiveSummaryService): JsonResponse
    {
        return response()->json(
            $fetchActiveSummaryService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param UpdateRequest $request
     * @param Domain $domain
     * @param UpdateService $updateService
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Domain $domain, UpdateService $updateService): JsonResponse
    {
        try {
            $updateService->handle($request->makeInput(), $domain);

            return response()->json(
                $updateService->getResponse(),
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
     * @throws Exception
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
     * @param Domain $domain
     * @param DomainRepositoryInterface $domainRepository
     * @return JsonResponse
     */
    public function delete(Domain $domain, DomainRepositoryInterface $domainRepository): JsonResponse
    {
        try {
            $domainRepository->delete($domain);

            return response()->json(
                [],
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
