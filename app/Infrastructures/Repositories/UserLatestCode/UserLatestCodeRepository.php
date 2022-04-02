<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\UserLatestCode;

use App\Infrastructures\Eloquent\Models\UserLatestCode;

final class UserLatestCodeRepository
{
    public function next(): int
    {
        $userLatestCode = UserLatestCode::firstOrFail();
        $userLatestCode->increment('code');

        return $userLatestCode->code;
    }
}
