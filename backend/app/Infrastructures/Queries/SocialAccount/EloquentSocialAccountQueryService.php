<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\SocialAccount;

use App\Infrastructures\Models\SocialAccount;

final class EloquentSocialAccountQueryService implements EloquentSocialAccountQueryServiceInterface
{
    public function firstByProviderIdProvider(
        string $provider_id,
        string $provider
    ): \App\Infrastructures\Models\SocialAccount {
        return SocialAccount::where('provider_id', $provider_id)
            ->where('provider_name', $provider)
            ->firstOrFail();
    }
}
