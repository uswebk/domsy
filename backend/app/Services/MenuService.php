<?php
declare(strict_types=1);

namespace App\Services;

use App\Constants\MenuConstant;
use App\Queries\Menu\MenuItemQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;

final class MenuService
{
    private MenuItemQueryServiceInterface $menuItemQueryService;

    public function __construct(
        MenuItemQueryServiceInterface $menuItemQueryService
    ) {
        $this->menuItemQueryService = $menuItemQueryService;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        $menuItems = $this->menuItemQueryService->getNavigationItems();

        if (auth()->user()->isCompany()) {
            return $menuItems;
        }

        return $menuItems->filter(function ($menuItem) {
            return $menuItem->menu->type_id !== MenuConstant::CORPORATION_MENU_TYPE_ID;
        });
    }
}
