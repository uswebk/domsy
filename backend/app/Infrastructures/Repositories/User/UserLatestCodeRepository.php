<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

use App\Infrastructures\Models\UserLatestCode;

final class UserLatestCodeRepository implements UserLatestCodeRepositoryInterface
{
    /**
     * @return integer
     */
    public function next(): int
    {
        $userLatestCode = UserLatestCode::firstOrFail();
        $userLatestCode->increment('code');

        return $userLatestCode->code;
    }
}
