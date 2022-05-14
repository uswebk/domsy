<?php

declare(strict_types=1);

namespace App\Infrastructures\Mails\SendServices;

use App\Infrastructures\Mails\Client\DomainExpiration;

final class DomainExpirationService
{
    public function execute(
        \App\Infrastructures\Models\Eloquent\User $user,
        \Illuminate\Database\Eloquent\Collection $domains
    ): void {
        $user->notify(new DomainExpiration($domains));
    }
}
