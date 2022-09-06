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
     * @param \App\Services\Application\DomainFetchService $domainFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\DomainFetchService $domainFetchService
    ) {
        return response()->json(
            $domainFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\DomainFetchTotalSellerService $domainFetchTotalSellerService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetchTotalSeller(
        \App\Services\Application\DomainFetchTotalSellerService $domainFetchTotalSellerService
    ) {
        return response()->json(
            $domainFetchTotalSellerService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\DomainFetchTransactionService $domainFetchTransactionService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetchTransition(
        \App\Services\Application\DomainFetchTransactionService $domainFetchTransactionService
    ) {
        return response()->json(
            $domainFetchTransactionService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\DomainFetchSortExpiredService $domainFetchSortExpiredService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchSortExpired(
        \App\Services\Application\DomainFetchSortExpiredService $domainFetchSortExpiredService
    ) {
        return response()->json(
            $domainFetchSortExpiredService->getResponseData(),
            Response::HTTP_OK
        );
    }

    public function fetchActiveSummary(
        \App\Services\Application\DomainFetchActiveSummaryService $domainFetchActiveSummaryService
    ) {
        return response()->json(
            $domainFetchActiveSummaryService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Domain\UpdateRequest $request
     * @param \App\Infrastructures\Models\Domain $domain
     * @param \App\Services\Application\DomainUpdateService $domainUpdateService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Domain\UpdateRequest $request,
        \App\Infrastructures\Models\Domain $domain,
        \App\Services\Application\DomainUpdateService $domainUpdateService
    ) {
        $domainRequest = $request->makeInput();
        $domainUpdateService->handle($domainRequest, $domain);

        return response()->json(
            $domainUpdateService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Domain\StoreRequest $request
     * @param \App\Services\Application\DomainStoreService $domainStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Domain\StoreRequest $request,
        \App\Services\Application\DomainStoreService $domainStoreService
    ) {
        $domainRequest = $request->makeInput();

        $domainStoreService->handle($domainRequest);

        return response()->json(
            $domainStoreService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\Domain $domain,
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
    ) {
        $domainRepository->delete($domain);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
