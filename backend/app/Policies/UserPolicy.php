<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\User $_user
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\User $_user
    ): bool {
        return $user->company_id == $_user->company_id;
    }
}
