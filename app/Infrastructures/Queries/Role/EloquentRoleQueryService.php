<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Role;

use App\Infrastructures\Models\Role;

final class EloquentRoleQueryService implements EloquentRoleQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Role
     */
    public function findById(int $id): \App\Infrastructures\Models\Role
    {
        return Role::find($id);
    }

    /**
     * @param integer $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCompanyId(int $companyId): \Illuminate\Database\Eloquent\Collection
    {
        return Role::where('company_id', '=', $companyId)->get();
    }
}
