<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Infrastructures\Models\User;

final class EloquentUserQueryService implements EloquentUserQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\User
     */
    public function findById(int $id): \App\Infrastructures\Models\User
    {
        return User::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Collection
     */
    public function getActiveUsers(): \Illuminate\Database\Collection
    {
        return User::whereNull('deleted_at')->get();
    }

    /**
     * @param integer $id
     * @param string $emailVerifyToken
     * @return \App\Infrastructures\Models\User
     */
    public function firstByIdEmailVerifyToken(
        int $id,
        string $emailVerifyToken
    ): \App\Infrastructures\Models\User {
        return User::where('id', '=', $id)->where('email_verify_token', '=', $emailVerifyToken)
        ->firstOrFail();
    }
}
