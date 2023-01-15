<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Domain $domain
     * @return boolean
     */
    public function owner(User $user, Domain $domain): bool
    {
        if ($user->isCompany()) {
            return in_array($domain->user_id, $user->getMemberIds());
        }

        return $user->id == $domain->user_id;
    }
}
