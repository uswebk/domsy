<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class DealingController extends Controller
{
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
}
