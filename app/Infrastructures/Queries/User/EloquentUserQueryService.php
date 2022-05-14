<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Infrastructures\Models\Eloquent\User;

final class EloquentUserQueryService
{
    public function firstByIdEmailVerifyToken(int $id, string $emailVerifyToken): User
    {
        return User::where('id', '=', $id)->where('email_verify_token', '=', $emailVerifyToken)
        ->firstOrFail();
    }
}
