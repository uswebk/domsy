<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\ClientResource;
use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\User;

use Illuminate\Support\Facades\Auth;

final class ClientFetchService
{
    private $clients;

    public function __construct()
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            //TODO: Query Service
            $this->clients = Client::whereIn('user_id', $user->getMemberIds())->get();
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
