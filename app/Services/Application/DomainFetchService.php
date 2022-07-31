<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\DomainResource;
use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class DomainFetchService
{
    private $domains;

    public function __construct()
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->domains = Domain::whereIn('user_id', $user->getMemberIds())->get();
        } else {
            $this->domains = Auth::user()->domains;
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DomainResource::collection($this->domains);
    }
}
