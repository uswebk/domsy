<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Menu;

use App\Constants\MenuConstant;
use App\Http\Resources\MenuItemResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $menuItems;

    /**
     * @param \App\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
     */
    public function __construct(
        \App\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
    ) {
        $user = User::find(Auth::id());

        $this->menuItems = new Collection();
        $menuItems = $eloquentMenuItemQueryService->getNavigationItems();

        if ($user->isCompany()) {
            $this->menuItems = $menuItems;
        } else {
            foreach ($menuItems as $menuItem) {
                if ($menuItem->menu->type_id !== MenuConstant::CORPORATION_MENU_TYPE_ID) {
                    $this->menuItems->push($menuItem);
                }
            }
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponse(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return MenuItemResource::collection($this->menuItems);
    }
}
