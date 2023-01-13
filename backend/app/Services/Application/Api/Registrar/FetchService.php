<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Registrar;

use App\Http\Resources\RegistrarResource;
use App\Models\User;
use App\Queries\Registrar\RegistrarQueryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class FetchService
{
    private Collection $registrars;

    /**
     * @param RegistrarQueryServiceInterface $registrarQueryServiceInterface
     */
    public function __construct(RegistrarQueryServiceInterface $registrarQueryServiceInterface)
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->registrars = $registrarQueryServiceInterface->getByUserIds($user->getMemberIds());
        } else {
            $this->registrars = $user->registrars;
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getResponse(): AnonymousResourceCollection
    {
        return RegistrarResource::collection($this->registrars);
    }
}
