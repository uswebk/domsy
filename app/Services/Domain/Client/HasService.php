<?php

declare(strict_types=1);

namespace App\Services\Domain\Client;

use App\Infrastructures\Queries\Client\EloquentClientQueryService;

use Exception;

final class HasService
{
    private $clientId;

    private $userId;

    private $clientQueryService;

    /**
     * @param integer $clientId
     * @param integer $userId
     */
    public function __construct(int $clientId, int $userId)
    {
        $this->clientId = $clientId;
        $this->userId = $userId;

        $this->clientQueryService = new EloquentClientQueryService();
    }

    /**
     * @return boolean
     */
    public function execute(): bool
    {
        try {
            $client = $this->clientQueryService->findById($this->clientId);

            if (! isset($client) || $client->user_id !== $this->userId) {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
