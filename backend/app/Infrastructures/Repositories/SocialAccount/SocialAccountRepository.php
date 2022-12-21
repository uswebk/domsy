<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\SocialAccount;

use App\Models\SocialAccount;

final class SocialAccountRepository implements SocialAccountRepositoryInterface
{
    /**
     * @param array $attributes
     * @return SocialAccount
     */
    public function store(array $attributes): \App\Models\SocialAccount
    {
        return SocialAccount::create($attributes);
    }
}
