<?php

declare(strict_types=1);

namespace App\Services\Application\Api\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Queries\User\UserQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class FetchService
{
    private Collection $users;

    /**
     * @param UserQueryServiceInterface $userQueryService
     */
    public function __construct(UserQueryServiceInterface $userQueryService)
    {
        $user = User::find(Auth::id());

        if (!$user->isCompany()) {
            abort(403);
        }

        $this->users = ($userQueryService->getActiveUsersByCompanyId($user->company_id))
            ->filter(function ($value, $key) use ($user) {
                return $value->id !== $user->id;
            });
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return UserResource::collection($this->users);
    }
}
