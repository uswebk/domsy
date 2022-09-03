<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuItemResource;
use App\Infrastructures\Models\MenuItem;
use Illuminate\Http\Response;

final class MenuController
{
    /**
     * @param \App\Services\Application\MenuFetchService $menuFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\MenuFetchService $menuFetchService
    ) {
        return response()->json(
            $menuFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetchItems()
    {
        $menuItems = MenuItem::with(['menu'])->get();

        return response()->json(
            MenuItemResource::collection($menuItems),
            Response::HTTP_OK
        );
    }
}
