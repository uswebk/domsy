<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DomainBilling;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainBillingPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param DomainBilling $domainBilling
     * @return boolean
     */
    public function owner(User $user, DomainBilling $domainBilling): bool
    {
        if ($user->isCompany()) {
            return in_array($domainBilling->getUserId(), $user->getMemberIds());
        }

        return $user->id == $domainBilling->getUserId();
    }
}
