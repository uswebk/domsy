<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

interface EloquentUserQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\User
     */
    public function findById(int $id): \App\Infrastructures\Models\User;

    /**
     * @return \Illuminate\Database\Collection
     */
    public function getActiveUsers(): \Illuminate\Database\Collection;

    /**
     * @param integer $id
     * @param string $emailVerifyToken
     * @return \App\Infrastructures\Models\User
     */
    public function firstByIdEmailVerifyToken(
        int $id,
        string $emailVerifyToken
    ): \App\Infrastructures\Models\User;
}
