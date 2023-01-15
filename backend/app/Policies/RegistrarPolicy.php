<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Registrar;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class RegistrarPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Registrar $registrar
     * @return boolean
     */
    public function owner(User $user, Registrar $registrar): bool
    {
        if ($user->isCompany()) {
            return in_array($registrar->user_id, $user->getMemberIds());
        }

        return $user->id == $registrar->user_id;
    }
}
