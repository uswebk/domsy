<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuResource;
use Illuminate\Http\Response;

final class MenuController
{
    /**
     * @param\App\Infrastructures\Queries\Menu\EloquentMenuQueryServiceInterface
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getMenus(
        \App\Infrastructures\Queries\Menu\EloquentMenuQueryServiceInterface $eloquentMenuQueryService
    ) {
        $menus = $eloquentMenuQueryService->getWithMenuItemsDisplayOnDashboard();

        return response()->json(
            MenuResource::collection($menus),
            Response::HTTP_OK
        );
    }
}
