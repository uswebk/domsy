<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Registrar;

use App\Http\Resources\RegistrarResource;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private $registrars;

    /**
     * @param \App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryServiceInterface $eloquentRegistrarQueryServiceInterface
     */
    public function __construct(
        \App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryServiceInterface $eloquentRegistrarQueryServiceInterface
    ) {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->registrars = $eloquentRegistrarQueryServiceInterface->getByUserIds($user->getMemberIds());
        } else {
            $this->registrars = $user->registrars;
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponse(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return RegistrarResource::collection($this->registrars);
    }
}
