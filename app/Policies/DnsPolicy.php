<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DnsPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return boolean
     */
    public function owner(
        \App\Infrastructures\Models\User $user,
        \App\Infrastructures\Models\Subdomain $subdomain
    ): bool {
        return $user->id == $subdomain->domain->user_id;
    }
}
