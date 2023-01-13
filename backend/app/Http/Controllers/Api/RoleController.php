<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Role\StoreRequest;
use App\Http\Requests\Api\Role\UpdateRequest;
use App\Models\Role;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Services\Application\Api\Role\FetchService;
use App\Services\Application\Api\Role\HasPageService;
use App\Services\Application\Api\Role\HasService;
use App\Services\Application\Api\Role\StoreService;
use App\Services\Application\Api\Role\UpdateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

final class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,role')->except([
            'fetch',
            'store',
            'has',
            'hasPage',
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
     * @param HasService $hasService
     * @return JsonResponse
     */
    public function has(HasService $hasService): JsonResponse
    {
        return response()->json(
            $hasService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param HasPageService $hasPageService
     * @return JsonResponse
     */
    public function hasPage(HasPageService $hasPageService): JsonResponse
    {
        return response()->json(
            [],
            $hasPageService->getResponseCode()
        );
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
     * @param UpdateRequest $request
     * @param UpdateService $updateService
     * @param Role $role
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, UpdateService $updateService, Role $role): JsonResponse
    {
        try {
            $updateService->handle($request->makeInput(), $role);

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
     * @param Role $role
     * @param RoleRepositoryInterface $roleRepository
     * @return JsonResponse
     */
    public function delete(Role $role, RoleRepositoryInterface $roleRepository): JsonResponse
    {
        try {
            $roleRepository->delete($role);

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
