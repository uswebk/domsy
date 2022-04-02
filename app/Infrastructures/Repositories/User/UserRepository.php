<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Eloquent\Models\User;

final class UserRepository
{
    public function findById(int $id): User
    {
        return User::find($id);
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function store(array $data): User
    {
        $user = new User();
        $user->fill($data)->save();

        return $user;
    }
}
