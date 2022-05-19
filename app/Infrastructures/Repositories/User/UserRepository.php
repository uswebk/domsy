<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Models\Eloquent\User;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\User $user
     * @return \App\Infrastructures\Models\Eloquent\User
     */
    public function save(
        \App\Infrastructures\Models\Eloquent\User $user
    ): \App\Infrastructures\Models\Eloquent\User {
        $user->save();

        return $user;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\User
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\User
    {
        $user = User::create($attributes);

        return $user;
    }
}
