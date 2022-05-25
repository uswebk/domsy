<?php

declare(strict_types=1);

namespace App\Services\Domain\Registrar;

use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryService;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class HasService
{
    private $userId;

    private $registrarId;

    /**
     * @param integer $userId
     * @param integer $registrarId
     */
    public function __construct(int $userId, int $registrarId)
    {
        $this->userId = $userId;
        $this->registrarId = $registrarId;
    }

    /**
     * @return boolean
     */
    public function isOwner(): bool
    {
        $registrarQueryService = new EloquentRegistrarQueryService();

        try {
            $registrarQueryService->firstByIdUserId($this->registrarId, $this->userId);
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }
}
