<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

interface EloquentMenuQueryServiceInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithMenuItemsDisplayOnDashboard(): \Illuminate\Database\Eloquent\Collection;
}
