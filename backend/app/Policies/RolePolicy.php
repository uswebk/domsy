<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class RolePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Role $role
     * @return boolean
     */
    public function owner(User $user, Role $role): bool
    {
        return $user->company_id == $role->company_id;
    }
}
