<?php

declare(strict_types=1);

namespace App\Queries\Role;

interface EloquentRoleQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\Role
     */
    public function findById(int $id): \App\Models\Role;

    /**
     * @param integer $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCompanyId(int $companyId): \Illuminate\Database\Eloquent\Collection;
}
