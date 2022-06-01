<?php

declare(strict_types=1);

namespace App\Services\Domain\Registrar;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class HasService
{
    private $eloquentRegistrarQueryService;

    /**
     * @param \App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryServiceInterface $eloquentRegistrarQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryServiceInterface $eloquentRegistrarQueryService
    ) {
        $this->eloquentRegistrarQueryService = $eloquentRegistrarQueryService;
    }

    /**
     * @param integer $id
     * @param integer $userId
     * @return boolean
     */
    public function isOwner(int $id, int $userId): bool
    {
        try {
            $this->eloquentRegistrarQueryService->firstByIdUserId($id, $userId);
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }
}
