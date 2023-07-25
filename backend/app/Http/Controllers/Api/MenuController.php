<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use App\Services\MenuService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

final class MenuController
{
    /**
     * @param MenuService $menuService
     * @return JsonResponse
     */
    public function fetch(MenuService $menuService): JsonResponse
    {
        try {
            return response()->json(MenuItemResource::collection($menuService->getAll()));
        } catch (ModelNotFoundException $e) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
