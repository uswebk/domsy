<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class HasPageService
{
    private $responseCode;

    /**
     * @param \App\Http\Requests\Api\Role\HasPageRequest $request
     * @param \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService
     * @param \App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
     */
    public function __construct(
        \App\Http\Requests\Api\Role\HasPageRequest $request,
        \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $eloquentUserQueryService,
        \App\Infrastructures\Queries\Menu\EloquentMenuItemQueryServiceInterface $eloquentMenuItemQueryService
    ) {
        try {
            $menuItem = $eloquentMenuItemQueryService->getByEndpoint($request->endpoint);
            $hasRole = ($eloquentUserQueryService->findById(Auth::id()))->hasRoleItem($menuItem->route);

            if ($hasRole) {
                $this->responseCode = Response::HTTP_OK;
            } else {
                $this->responseCode = Response::HTTP_FORBIDDEN;
            }
        } catch(ModelNotFoundException $e) {
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
