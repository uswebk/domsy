<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class RolePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\role $role
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\role $role
    ): bool {
        return $user->company_id == $role->company_id;
    }
}
