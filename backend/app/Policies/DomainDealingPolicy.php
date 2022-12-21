<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainDealingPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\DomainDealing $domainDealing
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\DomainDealing $domainDealing
    ): bool {
        if ($user->isCompany()) {
            return in_array($domainDealing->getUserId(), $user->getMemberIds());
        }

        return $user->id == $domainDealing->getUserId();
    }
}
