<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\RegistrarResource;
use App\Infrastructures\Models\Registrar;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class RegistrarFetchService
{
    private $registrars;

    public function __construct()
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            //TODO: Query Service
            $this->registrars = Registrar::whereIn('user_id', $user->getMemberIds())->get();
        } else {
            $this->registrars = $user->registrars;
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return RegistrarResource::collection($this->registrars);
    }
}
