<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

use App\Infrastructures\Models\Menu;

final class EloquentMenuQueryService implements EloquentMenuQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Menu
     */
    public function findById(int $id): \App\Infrastructures\Models\Menu
    {
        return Menu::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithMenuItemsDisplayOnDashboard(): \Illuminate\Database\Eloquent\Collection
    {
        return Menu::with(['menuItems' => function ($query) {
            $query->where('is_screen', '=', true);
        }])->where('is_nav', '=', true)->get();
    }
}
