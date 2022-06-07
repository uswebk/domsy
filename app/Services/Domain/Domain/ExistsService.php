<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ExistsService
{
    private $eloquentDomainQueryService;

    /**
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $this->eloquentDomainQueryService = $eloquentDomainQueryService;
    }

    /**
     * @param integer $domainId
     * @param integer $userId
     * @return boolean
     */
    public function exists(int $domainId, int $userId): bool
    {
        try {
            $this->eloquentDomainQueryService->getFirstByIdUserId($domainId, $userId);
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }
}
