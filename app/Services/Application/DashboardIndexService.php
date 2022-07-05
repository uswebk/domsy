<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\MenuResource;

final class DashboardIndexService
{
    private $menus;

    public function __construct(
        \App\Infrastructures\Queries\Menu\EloquentMenuQueryServiceInterface $eloquentMenuQueryService
    ) {
        $this->menus = $eloquentMenuQueryService->getWithMenuItemsDisplayOnDashboard();
    }

    /**
     * @return string
     */
    public function getMenuResource(): string
    {
        return json_encode(MenuResource::collection($this->menus));
    }
}
