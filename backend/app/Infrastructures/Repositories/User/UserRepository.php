<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Models\User;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @param \App\Models\User $user
     * @return \App\Models\User
     */
    public function save(
        \App\Models\User $user
    ): \App\Models\User {
        $user->save();

        return $user;
    }

    /**
     * @param \App\Models\User $user
     * @return \App\Models\User
     */
    public function delete(
        \App\Models\User $user
    ): \App\Models\User {
        $user->fill(['deleted_at' => now()])->save();

        return $user;
    }

    /**
     * @param array $attributes
     * @return \App\Models\User
     */
    public function store(array $attributes): \App\Models\User
    {
        $user = User::create($attributes);

        return $user;
    }
}
