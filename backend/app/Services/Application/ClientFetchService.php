<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\ClientResource;
use App\Infrastructures\Models\User;

use Illuminate\Support\Facades\Auth;

final class ClientFetchService
{
    private $clients;

    /**
     * @param \App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface $eloquentClientQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface $eloquentClientQueryService
    ) {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->clients = $eloquentClientQueryService->getByUserIds($user->getMemberIds());
        } else {
            $this->clients = $user->clients;
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ClientResource::collection($this->clients);
    }
}
