<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

interface EloquentMenuItemQueryServiceInterface
{
    /**
     * @param string $endpoint
     * @return \App\Infrastructures\Models\MenuItem
     */
    public function getByEndpoint(string $endpoint): \App\Infrastructures\Models\MenuItem;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNavigationItems(): \Illuminate\Database\Eloquent\Collection;
}
