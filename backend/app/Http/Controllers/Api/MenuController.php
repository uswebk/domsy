<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuItemResource;
use App\Infrastructures\Models\MenuItem;
use Illuminate\Http\Response;

final class MenuController
{
    /**
     * @param \App\Services\Application\Api\Menu\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Menu\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
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
