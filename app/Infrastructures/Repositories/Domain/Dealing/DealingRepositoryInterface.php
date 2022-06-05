<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Dealing;

interface DealingRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function save(\App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing): \App\Infrastructures\Models\Eloquent\DomainDealing;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\DomainDealing;

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing): void;
}
