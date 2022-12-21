<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

use App\Models\Menu;

final class EloquentMenuQueryService implements EloquentMenuQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\Menu
     */
    public function findById(int $id): \App\Models\Menu
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
