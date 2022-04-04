<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Eloquent\Models\User;

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

    public function store(array $data): User
    {
        $this->model->fill($data)->save();

        return $this->model;
    }
}
