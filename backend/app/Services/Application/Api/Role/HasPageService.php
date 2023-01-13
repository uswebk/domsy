<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use App\Http\Requests\Api\Role\HasPageRequest;
use App\Queries\Menu\MenuItemQueryServiceInterface;
use App\Queries\User\EloquentUserQueryServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class HasPageService
{
    private int $responseCode;

    /**
     * @param HasPageRequest $request
     * @param EloquentUserQueryServiceInterface $userQueryService
     * @param MenuItemQueryServiceInterface $menuItemQueryService
     */
    public function __construct(
        HasPageRequest $request,
        EloquentUserQueryServiceInterface $userQueryService,
        MenuItemQueryServiceInterface $menuItemQueryService
    ) {
        try {
            $menuItem = $menuItemQueryService->getByEndpoint($request->endpoint);
            $hasRole = ($userQueryService->findById(Auth::id()))->hasRoleItem($menuItem->route);

            if ($hasRole) {
                $this->responseCode = Response::HTTP_OK;
            } else {
                $this->responseCode = Response::HTTP_FORBIDDEN;
            }
        } catch (ModelNotFoundException $e) {
            $this->responseCode = Response::HTTP_FORBIDDEN;
        }
    }

    /**
     * @return integer
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}
