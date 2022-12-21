<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainBillingPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\DomainDealing $domainDealing
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\DomainBilling $domainBilling
    ): bool {
        if ($user->isCompany()) {
            return in_array($domainBilling->getUserId(), $user->getMemberIds());
        }

        return $user->id == $domainBilling->getUserId();
    }
}
