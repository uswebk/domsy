<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Infrastructures\Models\Eloquent\User;

final class EloquentUserQueryService
{
    public function getByDeletedAtNull(): \Illuminate\Database\Eloquent\Collection
    {
        return User::whereNull('deleted_at')->get();
    }
    public function firstByIdEmailVerifyToken(int $id, string $emailVerifyToken): User
    {
        return User::where('id', '=', $id)->where('email_verify_token', '=', $emailVerifyToken)
        ->firstOrFail();
    }
}
