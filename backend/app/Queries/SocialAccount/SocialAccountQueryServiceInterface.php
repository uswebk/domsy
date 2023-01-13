<?php

declare(strict_types=1);

namespace App\Queries\SocialAccount;

interface SocialAccountQueryServiceInterface
{
    /**
     * @param string $provider_id
     * @param string $provider
     * @return \App\Models\SocialAccount
     */
    public function firstByProviderIdProvider(
        string $provider_id,
        string $provider
    ): \App\Models\SocialAccount;
}
