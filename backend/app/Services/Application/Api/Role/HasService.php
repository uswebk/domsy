<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class HasService
{
    private $response;

    /**
     *
     * @param \App\Http\Requests\Api\Role\HasRequest $request
     * @param \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService
     * @param \App\Infrastructures\Queries\Menu\EloquentMenuQueryServiceInterface $eloquentMenuQueryService
     */
    public function __construct(
        \App\Http\Requests\Api\Role\HasRequest $request,
        \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService,
        \App\Infrastructures\Queries\Menu\EloquentMenuQueryServiceInterface $eloquentMenuQueryService
    ) {
        $user = $eloquentUserQueryService->findById(Auth::id());
        $menus = $eloquentMenuQueryService->findById((int) $request->menu_id);
        $menus->load('menuItems');

        $this->response = new Collection();
        foreach ($menus->menuItems as $menuItem) {
            $this->response[$menuItem->function] = $user->hasRoleItem($menuItem->route);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getResponse(): \Illuminate\Support\Collection
    {
        return $this->response;
    }
}
