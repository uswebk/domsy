<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

interface EloquentMenuItemQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNavigationItems(): \Illuminate\Database\Eloquent\Collection;
}
