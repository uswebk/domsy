<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Registrar;

use App\Http\Resources\RegistrarResource;
use App\Models\User;
use App\Queries\Registrar\RegistrarQueryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{

    private RegistrarQueryServiceInterface $registrarQueryService;

    /**
     * @param RegistrarQueryServiceInterface $registrarQueryService
     */
    public function __construct(RegistrarQueryServiceInterface $registrarQueryService)
    {
        $this->registrarQueryService = $registrarQueryService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $registrars = $this->registrarQueryService->getByUserIds($user->getMemberIds());
        } else {
            $registrars = $user->registrars;
        }

        return RegistrarResource::collection($registrars);
    }
}
