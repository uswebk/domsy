<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,role')->except(['fetch','store']);
    }

    /**
     * @param \App\Services\Application\RoleFetchService $roleFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\RoleFetchService $roleFetchService
    ) {
        return response()->json(
            $roleFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    public function has(
        \Illuminate\Http\Request $request
    ) {
        $routeName = $request->route_name;
    }

    /**
     * @param \App\Http\Requests\Api\Role\StoreRequest $request
     * @param \App\Services\Application\RoleStoreService $roleStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Role\StoreRequest $request,
        \App\Services\Application\RoleStoreService $roleStoreService
    ) {
        $attribute = $request->makeInput();
        $roleStoreService->handle($attribute);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Role\UpdateRequest $request
     * @param \App\Services\Application\RoleUpdateService $roleUpdateService
     * @param \App\Infrastructures\Models\Role $role
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Role\UpdateRequest $request,
        \App\Services\Application\RoleUpdateService $roleUpdateService,
        \App\Infrastructures\Models\Role $role
    ) {
        $attribute = $request->makeInput();

        $roleUpdateService->handle($attribute, $role);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\Role $role
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\Role $role
    ) {
        $role->delete();

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
