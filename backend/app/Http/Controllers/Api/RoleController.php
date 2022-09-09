<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,role')->except([
            'fetch',
            'store',
            'has',
            'hasPage'
        ]);
    }

    /**
     * @param \App\Services\Application\Api\Role\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Role\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Role\HasService $hasService
     * @return \Illuminate\Http\JsonResponse
     */
    public function has(
        \App\Services\Application\Api\Role\HasService $hasService
    ) {
        return response()->json(
            $hasService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Services\Application\Api\Role\HasPageService $hasPageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function hasPage(
        \App\Services\Application\Api\Role\HasPageService $hasPageService
    ) {
        return response()->json(
            [],
            $hasPageService->getResponseCode()
        );
    }

    /**
     * @param \App\Http\Requests\Api\Role\StoreRequest $request
     * @param \App\Services\Application\RoleStoreService $roleStoreService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Role\StoreRequest $request,
        \App\Services\Application\Api\Role\StoreService $storeService
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
     * @param \App\Http\Requests\Api\Role\UpdateRequest $request
     * @param \App\Services\Application\Api\Role\UpdateService $roleUpdateService
     * @param \App\Infrastructures\Models\Role $role
     * @return void
     */
    public function update(
        \App\Http\Requests\Api\Role\UpdateRequest $request,
        \App\Services\Application\Api\Role\UpdateService $updateService,
        \App\Infrastructures\Models\Role $role
    ) {
        try {
            $updateService->handle($request->makeInput(), $role);

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
     * @param \App\Infrastructures\Models\Role $role
     * @return\Illuminate\Http\JsonResponse
     */
    public function delete(
        \App\Infrastructures\Models\Role $role
    ) {
        try {
            // TODO: Repository
            $role->delete();

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
