<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Role;

use App\Models\Role;

final class EloquentRoleQueryService implements EloquentRoleQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\Role
     */
    public function findById(int $id): \App\Models\Role
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
