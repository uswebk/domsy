<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\SocialAccount;

interface EloquentSocialAccountQueryServiceInterface
{
    /**
     * @param string $provider_id
     * @param string $provider
     * @return \App\Infrastructures\Models\SocialAccount
     */
    public function firstByProviderIdProvider(
        string $provider_id,
        string $provider
    ): \App\Infrastructures\Models\SocialAccount;
}
