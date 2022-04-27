<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Dealing;

use App\Infrastructures\Models\Eloquent\DomainDealing;

interface DomainDealingRepositoryInterface
{
    public function save(DomainDealing $domainDealing): DomainDealing;

    public function store(array $attributes): DomainDealing;

    public function delete(DomainDealing $domainDealing): void;
}
