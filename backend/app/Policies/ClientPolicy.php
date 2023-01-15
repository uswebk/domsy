<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Client $client
     * @return boolean
     */
    public function owner(User $user, Client $client): bool
    {
        if ($user->isCompany()) {
            return in_array($client->user_id, $user->getMemberIds());
        }

        return $user->id === $client->user_id;
    }
}
