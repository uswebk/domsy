<?php

declare(strict_types=1);

namespace App\Services\Domain\Client;

final class HasService
{
    private $clientId;
    private $userId;

    public function __construct(int $clientId, int $userId)
    {
        $this->clientId = $clientId;
        $this->userId = $userId;
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
