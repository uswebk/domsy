<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Menu;

interface EloquentMenuQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Menu
     */
    public function findById(int $id): \App\Infrastructures\Models\Menu;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithMenuItemsDisplayOnDashboard(): \Illuminate\Database\Eloquent\Collection;
}
