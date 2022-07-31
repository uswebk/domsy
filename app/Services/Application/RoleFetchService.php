<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Constants\RoleConstant;
use App\Http\Resources\RoleResource;
use App\Infrastructures\Models\Role;

use Illuminate\Support\Facades\Auth;

final class RoleFetchService
{
    private $roles;

    public function __construct()
    {
        $user = Auth::user();

        //TODO: Query Service
        $adminRole = Role::find(RoleConstant::DEFAULT_ROLE_ID);

        //TODO: Query Service
        $this->roles = Role::where('company_id', '=', $user->company_id)->get();
        $this->roles->prepend($adminRole);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return RoleResource::collection($this->roles);
    }
}
