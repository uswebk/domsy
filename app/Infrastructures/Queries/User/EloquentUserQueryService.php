<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Infrastructures\Models\Eloquent\User;

final class EloquentUserQueryService
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function firstOrFailByEmailVerifyTokenUserId(
        string $emailVerifyToken,
        int $userId
    ): User {
        return $this->model->where('email_verify_token', $emailVerifyToken)
        ->where('id', $userId)
        ->firstOrFail();
    }
}
