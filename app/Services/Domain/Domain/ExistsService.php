<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Exceptions\Client\DomainNotExistsException;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ExistsService
{
    private $domainId;

    private $userId;

    /**
     * @param integer $domainId
     * @param integer $userId
     */
    public function __construct(int $domainId, int $userId)
    {
        $this->domainId = $domainId;
        $this->userId = $userId;
    }

    /**
     * @return boolean
     * @throws DomainNotExistsException
     */
    public function exists(): bool
    {
        $domainQueryService = new EloquentDomainQueryService();

        try {
            $domainQueryService->getFirstByIdUserId($this->domainId, $this->userId);
        } catch (ModelNotFoundException $e) {
            throw new DomainNotExistsException();
        }

        return true;
    }
}
