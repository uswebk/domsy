<?php

declare(strict_types=1);

namespace App\Queries\SocialAccount;

use App\Models\SocialAccount;

final class EloquentSocialAccountQueryService implements SocialAccountQueryServiceInterface
{
    public function firstByProviderIdProvider(string $provider_id, string $provider): SocialAccount
    {
        return SocialAccount::where('provider_id', $provider_id)
            ->where('provider_name', $provider)
            ->firstOrFail();
    }
}
