<?php

declare(strict_types=1);

namespace App\Queries\Menu;

use App\Models\MenuItem;

final class EloquentMenuItemQueryService implements EloquentMenuItemQueryServiceInterface
{
    /**
     * @param string $endpoint
     * @return \App\Models\MenuItem
     */
    public function getByEndpoint(string $endpoint): \App\Models\MenuItem
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