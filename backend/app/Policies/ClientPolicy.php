<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Infrastructures\Models\User $user
     * @param \App\Infrastructures\Models\Client $client
     * @return boolean
     */
    public function owner(
        \App\Infrastructures\Models\User $user,
        \App\Infrastructures\Models\Client $client
    ): bool {
        if ($user->isCompany()) {
            return in_array($client->user_id, $user->getMemberIds());
        }

        return $user->id === $client->user_id;
    }
}
