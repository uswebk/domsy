<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Infrastructures\Queries\Registrar\EloquentRegistrarQueryService;

use Exception;

final class HasRegistrarService
{
    private $userId;
    private $registrar_id;

    public function __construct(int $userId, int $registrar_id)
    {
        $this->userId = $userId;
        $this->registrar_id = $registrar_id;
    }

    public function execute(): bool
    {
        $registrarQueryService = new EloquentRegistrarQueryService();
        $registrar = $registrarQueryService->findById($this->registrar_id);

        if (! isset($registrar) || $registrar->user_id !== $this->userId) {
            throw new Exception();
        }

        return true;
    }
}
