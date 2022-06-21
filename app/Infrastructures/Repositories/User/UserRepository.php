<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Models\User;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\User $user
     * @return \App\Infrastructures\Models\User
     */
    public function save(
        \App\Infrastructures\Models\User $user
    ): \App\Infrastructures\Models\User {
        $user->save();

        return $user;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\User
     */
    public function store(array $attributes): \App\Infrastructures\Models\User
    {
        $user = User::create($attributes);

        return $user;
    }
}
