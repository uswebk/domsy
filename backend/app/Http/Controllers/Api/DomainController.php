<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

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
     * @param \App\Services\Application\Api\Domain\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Domain\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Domain\FetchTotalSellerService $fetchTotalSellerService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTotalSeller(
        \App\Services\Application\Api\Domain\FetchTotalSellerService $fetchTotalSellerService
    ) {
        return response()->json(
            $fetchTotalSellerService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Domain\FetchTransactionService $fetchTransactionService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTransition(
        \App\Services\Application\Api\Domain\FetchTransactionService $fetchTransactionService
    ) {
        return response()->json(
            $fetchTransactionService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Domain\FetchSortExpiredService $fetchSortExpiredService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchSortExpired(
        \App\Services\Application\Api\Domain\FetchSortExpiredService $fetchSortExpiredService
    ) {
        return response()->json(
            $fetchSortExpiredService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Domain\FetchActiveSummaryService $fetchActiveSummaryService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchActiveSummary(
        \App\Services\Application\Api\Domain\FetchActiveSummaryService $fetchActiveSummaryService
    ) {
        return response()->json(
            $fetchActiveSummaryService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Domain\UpdateRequest $request
     * @param \App\Infrastructures\Models\Domain $domain
     * @param \App\Services\Application\Api\Domain\UpdateService $updateService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Domain\UpdateRequest $request,
        \App\Infrastructures\Models\Domain $domain,
        \App\Services\Application\Api\Domain\UpdateService $updateService
    ) {
        try {
            $updateService->handle($request->makeInput(), $domain);

            return response()->json(
                $updateService->getResponse(),
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
     * @param \App\Http\Requests\Api\Domain\StoreRequest $request
     * @param \App\Services\Application\Api\Domain\StoreService $storeService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Domain\StoreRequest $request,
        \App\Services\Application\Api\Domain\StoreService $storeService
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

    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(
        \App\Infrastructures\Models\Domain $domain,
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
    ) {
        try {
            $domainRepository->delete($domain);

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
