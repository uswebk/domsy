<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * @param \App\Models\User $user
     * @return \App\Models\User
     */
    public function save(\App\Models\User $user): \App\Models\User;

    /**
     * @param \App\Models\User $user
     * @return \App\Models\User
     */
    public function delete(\App\Models\User $user): \App\Models\User;

    /**
     * @param array $attributes
     * @return \App\Models\User
     */
    public function store(array $attributes): \App\Models\User;
}
