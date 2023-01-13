<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Dns\StoreRequest;
use App\Http\Requests\Api\Dns\UpdateRequest;
use App\Http\Resources\SubdomainResource;
use App\Models\Subdomain;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Application\Api\Dns\ApplyService;
use App\Services\Application\Api\Dns\FetchService;
use App\Services\Application\Api\Dns\StoreService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DnsController extends Controller
{
    protected SubdomainRepositoryInterface $subdomainRepository;

    /**
     * @param SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(SubdomainRepositoryInterface $subdomainRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,subdomain')->except(['fetch', 'store', 'apply']);

        $this->subdomainRepository = $subdomainRepository;
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
     * @param UpdateRequest $request
     * @param Subdomain $subdomain
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Subdomain $subdomain): JsonResponse
    {
        try {
            $subdomain->fill($request->makeInput());
            $subdomain = $this->subdomainRepository->save($subdomain);

            return response()->json(
                new SubdomainResource($subdomain),
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
     * @param Subdomain $subdomain
     * @return JsonResponse
     */
    public function delete(Subdomain $subdomain): JsonResponse
    {
        try {
            $this->subdomainRepository->delete($subdomain);

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

    /**
     * @param ApplyService $applyService
     * @return JsonResponse
     */
    public function apply(ApplyService $applyService): JsonResponse
    {
        try {
            $applyService->handle();

            return response()->json(
                $applyService->getResponse(),
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
