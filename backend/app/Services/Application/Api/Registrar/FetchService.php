<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Registrar;

use App\Http\Resources\RegistrarResource;
use App\Models\User;
use App\Queries\Registrar\RegistrarQueryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @param int $user_id
     * @return AnonymousResourceCollection
     */
    public function getResponse(int $user_id): AnonymousResourceCollection
    {
        $user = User::findOrFail($user_id);

        if ($user->isCompany()) {
            $registrars = $this->registrarQueryService->getByUserIds($user->getMemberIds());

            return RegistrarResource::collection($registrars);
        }

        return RegistrarResource::collection($user->registrars);
    }
}
