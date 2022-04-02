<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Infrastructures\Eloquent\Models\User;

final class EloquentUserQueryService
{
    public function firstByEmailVerifyToken(string $emailVerifyToken): User
    {
        return User::where('email_verify_token', $emailVerifyToken)->firstOrFail();
    }
}
