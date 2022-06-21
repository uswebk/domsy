<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainDealingPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return boolean
     */
    public function owner(
        \App\Infrastructures\Models\User $user,
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ): bool {
        return $user->id == $domainDealing->domain->user_id;
    }
}
