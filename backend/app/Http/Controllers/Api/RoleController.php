<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Infrastructures\Models\Menu;
use App\Infrastructures\Models\MenuItem;
use App\Infrastructures\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,role')->except(['fetch','store','user', 'userPage']);
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

    /**
     * //TODO: ApplicationService化
     *
     * @param \App\Http\Requests\Api\Role\UserRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function user(
        \App\Http\Requests\Api\Role\UserRequest $request
    ) {
        $user = User::find(Auth::id());
        $menus = Menu::with(['menuItems'])->findOrFail($request->menu_id);

        $response = new Collection();
        foreach ($menus->menuItems as $menuItem) {
            $response[$menuItem->function] = $user->hasRoleItem($menuItem->route);
        }

        return response()->json(
            $response,
            Response::HTTP_OK
        );
    }

    /**
     * //TODO: ApplicationService化
     *
     * @param \App\Http\Requests\Api\Role\UserPageRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function userPage(\App\Http\Requests\Api\Role\UserPageRequest $request)
    {
        try {
            $menuItem = MenuItem::where('endpoint', $request->endpoint)->firstOrFail();
            $hasRole = (User::findOrFail(Auth::id()))->hasRoleItem($menuItem->route);

            if ($hasRole) {
                $responseCode = Response::HTTP_OK;
            } else {
                $responseCode = Response::HTTP_FORBIDDEN;
            }
        } catch(ModelNotFoundException $e) {
            $responseCode = Response::HTTP_FORBIDDEN;
        }

        return response()->json(
            [],
            $responseCode
        );
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
