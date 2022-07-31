<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class RegistrarPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return boolean
     */
    public function owner(
        \App\Infrastructures\Models\User $user,
        \App\Infrastructures\Models\Registrar $registrar
    ): bool {
        if ($user->isCompany()) {
            return in_array($registrar->user_id, $user->getMemberIds());
        } else {
            return $user->id == $registrar->user_id;
        }
    }
}
