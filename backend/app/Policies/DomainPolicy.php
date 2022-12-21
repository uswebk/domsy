<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Domain $domain
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\Domain $domain
    ): bool {
        if ($user->isCompany()) {
            return in_array($domain->user_id, $user->getMemberIds());
        }

        return $user->id == $domain->user_id;
    }
}
