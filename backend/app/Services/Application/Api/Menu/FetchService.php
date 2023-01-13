<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Menu;

use App\Constants\MenuConstant;
use App\Http\Resources\MenuItemResource;
use App\Models\User;
use App\Queries\Menu\MenuItemQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $menuItems;

    /**
     * @param MenuItemQueryServiceInterface $menuItemQueryService
     */
    public function __construct(MenuItemQueryServiceInterface $menuItemQueryService)
    {
        $user = User::find(Auth::id());

        $this->menuItems = new Collection();
        $menuItems = $menuItemQueryService->getNavigationItems();

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
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return MenuItemResource::collection($this->menuItems);
    }
}
