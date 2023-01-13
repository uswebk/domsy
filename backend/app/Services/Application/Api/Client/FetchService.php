<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Client;

use App\Http\Resources\ClientResource;
use App\Models\User;
use App\Queries\Client\ClientQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $clients;

    /**
     * @param ClientQueryServiceInterface $clientQueryService
     */
    public function __construct(ClientQueryServiceInterface $clientQueryService)
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->clients = $clientQueryService->getByUserIds($user->getMemberIds());
        } else {
            $this->clients = $user->clients;
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return ClientResource::collection($this->clients);
    }
}
