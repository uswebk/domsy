<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Dealing;

use App\Infrastructures\Models\DomainDealing;

final class DealingRepository implements DealingRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return \App\Infrastructures\Models\DomainDealing
     */
    public function save(
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ): \App\Infrastructures\Models\DomainDealing {
        $domainDealing->save();

        return $domainDealing;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\DomainDealing
     */
    public function store(array $attributes): \App\Infrastructures\Models\DomainDealing
    {
        $domainDealing = DomainDealing::create($attributes);

        return $domainDealing;
    }

    /**
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return void
     */
    public function delete(\App\Infrastructures\Models\DomainDealing $domainDealing): void
    {
        $domainDealing->delete();
    }
}
