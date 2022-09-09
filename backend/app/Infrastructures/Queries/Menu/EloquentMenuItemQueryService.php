<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

use App\Infrastructures\Models\MenuItem;

final class EloquentMenuItemQueryService implements EloquentMenuItemQueryServiceInterface
{
    /**
     * @param string $endpoint
     * @return \App\Infrastructures\Models\MenuItem
     */
    public function getByEndpoint(string $endpoint): \App\Infrastructures\Models\MenuItem
    {
        return MenuItem::where('endpoint', $endpoint)->firstOrFail();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNavigationItems(): \Illuminate\Database\Eloquent\Collection
    {
        return MenuItem::with(['menu' => function ($query) {
            $query->where('is_nav', '=', true);
        }])->where('is_screen', '=', true)->get();
    }
}
