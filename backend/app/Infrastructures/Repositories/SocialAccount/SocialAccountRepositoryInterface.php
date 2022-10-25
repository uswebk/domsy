<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\SocialAccount;

interface SocialAccountRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\SocialAccount
     */
    public function store(array $attributes): \App\Infrastructures\Models\SocialAccount;
}
