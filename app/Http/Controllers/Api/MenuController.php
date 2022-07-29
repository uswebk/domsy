<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\MenuItemResource;
use App\Infrastructures\Models\MenuItem;
use App\Infrastructures\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class MenuController
{
    /**
     * @param \App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getMenus(
        \App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
    ) {
        $user = User::find(Auth::id());

        $menuItems = new Collection();
        $_menuItems = $eloquentMenuItemQueryService->getNavigationItems();

        if ($user->isCompany()) {
            $menuItems = $_menuItems;
        } else {
            foreach ($_menuItems as $menuItem) {
                if ($menuItem->menu->type_id !== 4) {
                    $menuItems->push($menuItem);
                }
            }
        }

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
