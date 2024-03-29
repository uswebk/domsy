<?php

declare(strict_types=1);

namespace App\Queries\Menu;

interface MenuItemQueryServiceInterface
{
    /**
     * @param string $endpoint
     * @return \App\Models\MenuItem
     */
    public function getByEndpoint(string $endpoint): \App\Models\MenuItem;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNavigationItems(): \Illuminate\Database\Eloquent\Collection;
}
