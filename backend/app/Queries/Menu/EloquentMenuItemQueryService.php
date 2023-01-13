<?php

declare(strict_types=1);

namespace App\Queries\Menu;

use App\Models\MenuItem;

final class EloquentMenuItemQueryService implements MenuItemQueryServiceInterface
{
    /**
     * @param string $endpoint
     * @return MenuItem
     */
    public function getByEndpoint(string $endpoint): MenuItem
    {
        return MenuItem::where('endpoint', $endpoint)->firstOrFail();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNavigationItems(): \Illuminate\Database\Eloquent\Collection
    {
        return MenuItem::join('menus', function ($join) {
            $join->on("menus.id", "=", "menu_items.parent_id")
                ->where("menus.is_nav", 1);
        })
            ->with(['menu'])
            ->where('is_screen', '=', true)
            ->select('menu_items.*')
            ->get();
    }
}
