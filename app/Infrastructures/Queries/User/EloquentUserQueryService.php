<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Infrastructures\Models\Eloquent\User;

final class EloquentUserQueryService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDeletedAtNull(): \Illuminate\Database\Eloquent\Collection
    {
        return User::whereNull('deleted_at')->get();
    }

    /**
     * @param integer $id
     * @param string $emailVerifyToken
     * @return \App\Infrastructures\Models\Eloquent\User
     */
    public function firstByIdEmailVerifyToken(
        int $id,
        string $emailVerifyToken
    ): \App\Infrastructures\Models\Eloquent\User {
        return User::where('id', '=', $id)->where('email_verify_token', '=', $emailVerifyToken)
        ->firstOrFail();
    }
}
