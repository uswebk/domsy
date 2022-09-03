<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Dealing;

interface DealingRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return \App\Infrastructures\Models\DomainDealing
     */
    public function save(\App\Infrastructures\Models\DomainDealing $domainDealing): \App\Infrastructures\Models\DomainDealing;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\DomainDealing
     */
    public function store(array $attributes): \App\Infrastructures\Models\DomainDealing;

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return void
     */
    public function delete(\App\Infrastructures\Models\DomainDealing $domainDealing): void;
}
