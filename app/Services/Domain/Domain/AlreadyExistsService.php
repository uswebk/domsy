<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Exceptions\Client\DomainExistsException;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;

final class AlreadyExistsService
{
    private $name;
    private $userId;

    public function __construct(string $name, int $userId)
    {
        $this->name = $name;
        $this->userId = $userId;
    }

    public function isNotExists(): bool
    {
        $domainQueryService = new EloquentDomainQueryService();
        $domain = $domainQueryService->getFirstByNameUserID($this->name, $this->userId);

        if (isset($domain)) {
            throw new DomainExistsException();
        }

        return true;
    }
}
