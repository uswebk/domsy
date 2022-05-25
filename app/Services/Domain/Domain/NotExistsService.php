<?php

declare(strict_types=1);

namespace App\Services\Domain\Domain;

use App\Exceptions\Client\DomainExistsException;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;

final class NotExistsService
{
    private $userId;

    private $name;

    /**
     * @param integer $userId
     * @param string $name
     */
    public function __construct(int $userId, string $name)
    {
        $this->userId = $userId;
        $this->name = $name;
    }

    /**
     * @return boolean
     * @throws DomainExistsException
     */
    public function isNotExists(): bool
    {
        $domainQueryService = new EloquentDomainQueryService();
        $domain = $domainQueryService->getFirstByNameUserId($this->name, $this->userId);

        if (isset($domain)) {
            throw new DomainExistsException();
        }

        return true;
    }
}
