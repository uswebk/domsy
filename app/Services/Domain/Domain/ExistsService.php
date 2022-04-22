<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Exceptions\Client\DomainNotExistsException;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;

final class ExistsService
{
    private $id;
    private $userId;

    public function __construct(string $id, int $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function execute(): bool
    {
        $domainQueryService = new EloquentDomainQueryService();
        $domain = $domainQueryService->getFirstByIdUserId($this->id, $this->userId);

        if (! isset($domain)) {
            throw new DomainNotExistsException();
        }

        return true;
    }
}
