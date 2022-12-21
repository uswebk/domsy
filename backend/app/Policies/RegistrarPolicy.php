<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class RegistrarPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Registrar $registrar
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\Registrar $registrar
    ): bool {
        if ($user->isCompany()) {
            return in_array($registrar->user_id, $user->getMemberIds());
        }

        return $user->id == $registrar->user_id;
    }
}
