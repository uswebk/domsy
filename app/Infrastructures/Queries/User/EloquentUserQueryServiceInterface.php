<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

interface EloquentUserQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Eloquent\User
     */
    public function findById(int $id): \App\Infrastructures\Models\Eloquent\User;

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUsers(): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param integer $id
     * @param string $emailVerifyToken
     * @return \App\Infrastructures\Models\Eloquent\User
     */
    public function firstByIdEmailVerifyToken(
        int $id,
        string $emailVerifyToken
    ): \App\Infrastructures\Models\Eloquent\User;
}
