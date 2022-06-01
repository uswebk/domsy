<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class NotExistsService
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
     * @return boolean
     */
    public function isNotExists(int $userId, string $name): bool
    {
        try {
            $domain = $this->eloquentDomainQueryService->getFirstByUserIdName($userId, $name);

            if (isset($domain)) {
                return false;
            }
        } catch (ModelNotFoundException $e) {
            return true;
        }

        return true;
    }
}
