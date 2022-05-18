<?php

declare(strict_types=1);

namespace App\Services\Domain\Registrar;

use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryService;

use Exception;

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
    public function execute(): bool
    {
        $registrarQueryService = new EloquentRegistrarQueryService();
        $registrar = $registrarQueryService->findById($this->registrarId);

        if (! isset($registrar) || $registrar->user_id !== $this->userId) {
            throw new Exception();
        }

        return true;
    }
}
