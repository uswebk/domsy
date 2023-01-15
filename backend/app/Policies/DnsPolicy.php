<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Subdomain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DnsPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Subdomain $subdomain
     * @return boolean
     */
    public function owner(User $user, Subdomain $subdomain): bool
    {
        if ($user->isCompany()) {
            return in_array($subdomain->domain->user_id, $user->getMemberIds());
        }

        return $user->id == $subdomain->domain->user_id;
    }
}
