<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

final class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function delete(User $user): User
    {
        $user->fill(['deleted_at' => now()])->save();

        return $user;
    }

    /**
     * @param array $attributes
     * @return User
     */
    public function store(array $attributes): User
    {
        $user = User::create($attributes);

        return $user;
    }
}
