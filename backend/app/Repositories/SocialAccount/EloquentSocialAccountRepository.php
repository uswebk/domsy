<?php

declare(strict_types=1);

namespace App\Repositories\SocialAccount;

use App\Models\SocialAccount;

final class EloquentSocialAccountRepository implements SocialAccountRepositoryInterface
{
    /**
     * @param array $attributes
     * @return SocialAccount
     */
    public function store(array $attributes): SocialAccount
    {
        return SocialAccount::create($attributes);
    }
}
