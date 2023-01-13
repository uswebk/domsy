<?php

declare(strict_types=1);

namespace App\Queries\User;

interface UserQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Models\User
     */
    public function findById(int $id): \App\Models\User;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUsers(): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param integer $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUsersByCompanyId(int $companyId): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param integer $id
     * @param string $emailVerifyToken
     * @return \App\Models\User
     */
    public function firstByIdEmailVerifyToken(
        int $id,
        string $emailVerifyToken
    ): \App\Models\User;
}
