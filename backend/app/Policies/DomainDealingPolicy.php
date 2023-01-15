<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DomainDealing;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainDealingPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param DomainDealing $domainDealing
     * @return boolean
     */
    public function owner(User $user, DomainDealing $domainDealing): bool
    {
        if ($user->isCompany()) {
            return in_array($domainDealing->getUserId(), $user->getMemberIds());
        }

        return $user->id == $domainDealing->getUserId();
    }
}
