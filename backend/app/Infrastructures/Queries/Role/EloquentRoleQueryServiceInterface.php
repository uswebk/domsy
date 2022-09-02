<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Role;

interface EloquentRoleQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Role
     */
    public function findById(int $id): \App\Infrastructures\Models\Role;

    /**
     * @param integer $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCompanyId(int $companyId): \Illuminate\Database\Eloquent\Collection;
}
