<?php

declare(strict_types=1);

namespace App\Repositories\SocialAccount;

interface SocialAccountRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\SocialAccount
     */
    public function store(array $attributes): \App\Models\SocialAccount;
}
