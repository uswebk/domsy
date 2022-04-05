<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Models\Eloquent\User;

final class UserRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function store(
        string $name,
        int $code,
        string $email,
        string $password,
        string $email_verify_token,
    ): User {
        $this->model->fill([
            'name' => $name,
            'code' => $code,
            'email' => $email,
            'password' => $password,
            'email_verify_token' => $email_verify_token,
        ])->save();

        return $this->model;
    }
}
