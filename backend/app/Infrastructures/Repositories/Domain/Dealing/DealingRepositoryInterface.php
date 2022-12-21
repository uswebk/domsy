<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Dealing;

interface DealingRepositoryInterface
{
    /**
     * @param \App\Models\DomainDealing $domainDealing
     * @return \App\Models\DomainDealing
     */
    public function save(\App\Models\DomainDealing $domainDealing): \App\Models\DomainDealing;

    /**
     * @param array $attributes
     * @return \App\Models\DomainDealing
     */
    public function store(array $attributes): \App\Models\DomainDealing;

    /**
     * @param \App\Models\DomainDealing $domainDealing
     * @return void
     */
    public function delete(\App\Models\DomainDealing $domainDealing): void;
}
