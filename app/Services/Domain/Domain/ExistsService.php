<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Exceptions\Client\DomainNotExistsException;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;

final class ExistsService
{
    private $domainId;
    private $userId;

    public function __construct(int $domainId, int $userId)
    {
        $this->domainId = $domainId;
        $this->userId = $userId;
    }

    public function execute(): bool
    {
        $domainQueryService = new EloquentDomainQueryService();
        $domain = $domainQueryService->getFirstByIdUserId($this->domainId, $this->userId);

        if (! isset($domain)) {
            throw new DomainNotExistsException();
        }

        return true;
    }
}
