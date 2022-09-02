<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \App\Infrastructures\Models\Domain $domain
     * @return boolean
     */
    public function owner(
        \App\Infrastructures\Models\User $user,
        \App\Infrastructures\Models\Domain $domain
    ): bool {
        if ($user->isCompany()) {
            return in_array($domain->user_id, $user->getMemberIds());
        }

        return $user->id == $domain->user_id;
    }
}
