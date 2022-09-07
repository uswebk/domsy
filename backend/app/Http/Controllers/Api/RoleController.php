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
     * //TODO: ApplicationService化
     *
     * @param \App\Http\Requests\Api\Role\UserRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
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
