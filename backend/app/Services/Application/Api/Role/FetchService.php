<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use App\Constants\RoleConstant;
use App\Http\Resources\RoleResource;
use App\Queries\Role\RoleQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $roles;

    /**
     * @param RoleQueryServiceInterface $roleQueryService
     */
    public function __construct(RoleQueryServiceInterface $roleQueryService)
    {
        $user = Auth::user();

        $adminRole = $roleQueryService->findById(RoleConstant::DEFAULT_ROLE_ID);

        $this->roles = $roleQueryService->getByCompanyId($user->company_id);

        $this->roles->prepend($adminRole);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return RoleResource::collection($this->roles);
    }
}
