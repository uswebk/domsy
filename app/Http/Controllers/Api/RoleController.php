<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Constants\RoleConstant;
use App\Http\Resources\RoleResource;
use App\Infrastructures\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class RoleController
{
    public function getRoles()
    {
        $user = Auth::user();

        $adminRole = Role::find(RoleConstant::DEFAULT_ROLE_ID);
        $roles = Role::where('company_id', '=', $user->company_id)->get();
        $roles->prepend($adminRole);

        return response()->json(
            RoleResource::collection($roles),
            Response::HTTP_OK
        );
    }
}
