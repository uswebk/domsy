<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainBillingPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return boolean
     */
    public function owner(
        \App\Infrastructures\Models\User $user,
        \App\Infrastructures\Models\DomainBilling $domainBilling
    ): bool {
        if ($user->isCompany()) {
            return in_array($domainBilling->getUserId(), $user->getMemberIds());
        }

        return $user->id == $domainBilling->getUserId();
    }
}
