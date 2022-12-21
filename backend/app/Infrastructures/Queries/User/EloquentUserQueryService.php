<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class EloquentUserQueryService implements EloquentUserQueryServiceInterface
{
    /**
     * @param integer $id
     * @return User
     */
    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function getActiveUsers(): Collection
    {
        return User::whereNull('deleted_at')->get();
    }

    /**
     * @param integer $companyId
     * @return Collection
     */
    public function getActiveUsersByCompanyId(int $companyId): Collection
    {
        return User::where('company_id', '=', $companyId)->whereNull('deleted_at')->get();
    }

    /**
     * @param integer $id
     * @param string $emailVerifyToken
     * @return User
     */
    public function firstByIdEmailVerifyToken(
        int $id,
        string $emailVerifyToken
    ): User {
        return User::where('id', '=', $id)->where('email_verify_token', '=', $emailVerifyToken)->firstOrFail();
    }
}
