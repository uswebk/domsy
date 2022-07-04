<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\MenuResource;
use App\Infrastructures\Models\Menu;

final class DashboardIndexService
{
    private $menus;

    public function __construct()
    {
        // use QueryService
        // getWithMenuItemsDisplayOnDashboard
        $this->menus = Menu::with(['menuItems' => function ($query) {
            $query->where('is_screen', '=', true);
        }])->where('is_nav', '=', true)->get();
    }

    /**
     * @return string
     */
    public function getMenuResource(): string
    {
        return json_encode(MenuResource::collection($this->menus));
    }
}
