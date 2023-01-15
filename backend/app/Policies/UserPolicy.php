<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param User $user2
     * @return bool
     */
    public function owner(User $user, User $user2): bool
    {
        return $user->company_id == $user2->company_id;
    }
}
