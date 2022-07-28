<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuItemResource;
use App\Infrastructures\Models\MenuItem;
use Illuminate\Http\Response;

final class MenuController
{
    /**
     * @param \App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getMenus(
        \App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
    ) {
        $menuItems = $eloquentMenuItemQueryService->getNavigationItems();

        return response()->json(
            MenuItemResource::collection($menuItems),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getMenuItems()
    {
        $menuItems = MenuItem::with(['menu'])->get();

        return response()->json(
            MenuItemResource::collection($menuItems),
            Response::HTTP_OK
        );
    }
}
