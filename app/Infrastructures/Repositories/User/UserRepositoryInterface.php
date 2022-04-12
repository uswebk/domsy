<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

interface UserRepositoryInterface
{
    public function save(\App\Infrastructures\Models\Eloquent\User $user): \App\Infrastructures\Models\Eloquent\User;

    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\User;
}
