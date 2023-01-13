<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use App\Http\Requests\Api\Role\HasRequest;
use App\Queries\Menu\MenuQueryServiceInterface;
use App\Queries\User\UserQueryServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class HasService
{
    private Collection $response;

    /**
     *
     * @param HasRequest $request
     * @param UserQueryServiceInterface $userQueryService
     * @param MenuQueryServiceInterface $menuQueryService
     */
    public function __construct(
        HasRequest $request,
        UserQueryServiceInterface $userQueryService,
        MenuQueryServiceInterface $menuQueryService
    ) {
        $user = $userQueryService->findById(Auth::id());
        $menus = $menuQueryService->findById((int) $request->menu_id);
        $menus->load('menuItems');

        $this->response = new Collection();
        foreach ($menus->menuItems as $menuItem) {
            $this->response[$menuItem->function] = $user->hasRoleItem($menuItem->route);
        }
    }

    /**
     * @return Collection
     */
    public function getResponse(): Collection
    {
        return $this->response;
    }
}
