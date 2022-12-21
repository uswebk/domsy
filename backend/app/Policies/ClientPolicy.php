<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Client $client
     * @return boolean
     */
    public function owner(
        \App\Models\User $user,
        \App\Models\Client $client
    ): bool {
        if ($user->isCompany()) {
            return in_array($client->user_id, $user->getMemberIds());
        }

        return $user->id === $client->user_id;
    }
}
