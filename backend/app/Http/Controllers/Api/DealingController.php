<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ExistsFixedBillingException;
use App\Http\Resources\DomainDealingResource;
use Exception;
use Illuminate\Http\Response;

final class DealingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domainDealing')->only(['fetchId']);
    }

    /**
     * @param \App\Services\Application\Api\Dealing\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Dealing\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return \Illuminate\Http\JsonResponse
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
     * @param \App\Http\Requests\Api\Dealing\UpdateRequest $request
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @param \App\Services\Application\Api\Dealing\UpdateService $updateService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Dealing\UpdateRequest $request,
        \App\Infrastructures\Models\DomainDealing $domainDealing,
        \App\Services\Application\Api\Dealing\UpdateService $updateService
    ) {
        try {
            $updateService->handle($request->makeInput(), $domainDealing);

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
     * @param \App\Http\Requests\Api\Dealing\StoreRequest $request
     * @param \App\Services\Application\Api\Dealing\StoreService $storeService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Dealing\StoreRequest $request,
        \App\Services\Application\Api\Dealing\StoreService $storeService
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
     * NOTE: Role Dummy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail()
    {
        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @param \App\Services\Application\Api\Dealing\DeleteService $deleteService
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(
        \App\Infrastructures\Models\DomainDealing $domainDealing,
        \App\Services\Application\Api\Dealing\DeleteService $deleteService
    ) {
        try {
            $deleteService->handle($domainDealing);

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch(ExistsFixedBillingException $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_FORBIDDEN
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
