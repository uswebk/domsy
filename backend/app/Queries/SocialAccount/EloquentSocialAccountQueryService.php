<?php

declare(strict_types=1);

namespace App\Queries\SocialAccount;

use App\Models\SocialAccount;

final class EloquentSocialAccountQueryService implements EloquentSocialAccountQueryServiceInterface
{
    public function firstByProviderIdProvider(
        string $provider_id,
        string $provider
    ): \App\Models\SocialAccount {
        return SocialAccount::where('provider_id', $provider_id)
            ->where('provider_name', $provider)
            ->firstOrFail();
    }
}
