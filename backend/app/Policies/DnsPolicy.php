<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DnsPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Subdomain $subdomain
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\Subdomain $subdomain
    ): bool {
        if ($user->isCompany()) {
            return in_array($subdomain->domain->user_id, $user->getMemberIds());
        }

        return $user->id == $subdomain->domain->user_id;
    }
}
