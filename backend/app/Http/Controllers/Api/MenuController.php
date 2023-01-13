<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use App\Services\Application\Api\Menu\FetchService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class MenuController
{
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
     * @return JsonResponse
     */
    public function fetchItems(): JsonResponse
    {
        $menuItems = MenuItem::with(['menu'])->get();

        return response()->json(
            MenuItemResource::collection($menuItems),
            Response::HTTP_OK
        );
    }
}
