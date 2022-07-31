<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\UserResource;
use App\Infrastructures\Models\User;

use Illuminate\Support\Facades\Auth;

final class UserFetchService
{
    private $users;

    public function __construct()
    {
        $user = User::find(Auth::id());

        if (! $user->isCompany()) {
            abort(403);
        }

        //TODO: Query Service
        $this->users = User::where('company_id', '=', $user->company_id)
        ->whereNull('deleted_at')->get();
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->users);
    }
}
