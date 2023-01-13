<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ExistsFixedBillingException;
use App\Http\Requests\Api\Dealing\StoreRequest;
use App\Http\Requests\Api\Dealing\UpdateRequest;
use App\Http\Resources\DomainDealingResource;
use App\Models\DomainDealing;
use App\Services\Application\Api\Dealing\DeleteService;
use App\Services\Application\Api\Dealing\FetchService;
use App\Services\Application\Api\Dealing\ResumeService;
use App\Services\Application\Api\Dealing\StoreService;
use App\Services\Application\Api\Dealing\UpdateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DealingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domainDealing')->only(['fetchId']);
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
     * @param DomainDealing $domainDealing
     * @return JsonResponse
     */
    public function fetchId(DomainDealing $domainDealing): JsonResponse
    {
        return response()->json(
            new DomainDealingResource($domainDealing),
            Response::HTTP_OK
        );
    }

    /**
     * @param UpdateRequest $request
     * @param DomainDealing $domainDealing
     * @param UpdateService $updateService
     * @return JsonResponse
     */
    public function update(
        UpdateRequest $request,
        DomainDealing $domainDealing,
        UpdateService $updateService
    ): JsonResponse {
        try {
            $updateService->handle($request->makeInput(), $domainDealing);

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
     * NOTE: Role Dummy
     *
     * @return JsonResponse
     */
    public function detail(): JsonResponse
    {
        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param DomainDealing $domainDealing
     * @param DeleteService $deleteService
     * @return JsonResponse
     */
    public function delete(DomainDealing $domainDealing, DeleteService $deleteService): JsonResponse
    {
        try {
            $deleteService->handle($domainDealing);

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch (ExistsFixedBillingException $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_FORBIDDEN
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param DomainDealing $domainDealing
     * @param ResumeService $resumeService
     * @return JsonResponse
     */
    public function resume(DomainDealing $domainDealing, ResumeService $resumeService): JsonResponse
    {
        try {
            $resumeService->handle($domainDealing);

            return response()->json(
                $resumeService->getResponse(),
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
