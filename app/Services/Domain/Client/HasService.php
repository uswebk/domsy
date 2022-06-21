<?php

declare(strict_types=1);

namespace App\Services\Domain\Client;

use Illuminate\Database\ModelNotFoundException;

final class HasService
{
    private $eloquentClientQueryService;

    /**
     * @param \App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface $eloquentClientQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface $eloquentClientQueryService
    ) {
        $this->eloquentClientQueryService = $eloquentClientQueryService;
    }

    /**
     * @param integer $clientId
     * @param integer $userId
     * @return boolean
     */
    public function isOwner(int $clientId, int $userId): bool
    {
        try {
            $client = $this->eloquentClientQueryService->findById($clientId);

            if ($client->user_id !== $userId) {
                return false;
            }
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }
}
