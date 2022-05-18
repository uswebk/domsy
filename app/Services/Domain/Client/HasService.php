<?php

declare(strict_types=1);

namespace App\Services\Domain\Client;

use App\Infrastructures\Queries\Client\EloquentClientQueryService;

final class HasService
{
    private $clientId;
    private $userId;

    /**
     * @param integer $clientId
     * @param integer $userId
     */
    public function __construct(int $clientId, int $userId)
    {
        $this->clientId = $clientId;
        $this->userId = $userId;
    }

    /**
     * @return boolean
     */
    public function execute(): bool
    {
        $clientQueryService = new EloquentClientQueryService();
        $client = $clientQueryService->findById($this->clientId);

        if (! isset($client) || $client->user_id !== $this->userId) {
            throw new \Exception();
        }

        return true;
    }
}
