<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Constants\RoleConstant;
use App\Http\Resources\RoleResource;
use App\Infrastructures\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,role')->except(['getRoles','store']);
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getRoles()
    {
        $user = Auth::user();

        $adminRole = Role::find(RoleConstant::DEFAULT_ROLE_ID);
        $roles = Role::where('company_id', '=', $user->company_id)->get();
        $roles->prepend($adminRole);

        return response()->json(
            RoleResource::collection($roles),
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
