<?php

declare(strict_types=1);

namespace App\Repositories\Domain\Dealing;

use App\Models\DomainDealing;

final class DealingRepository implements DealingRepositoryInterface
{
    /**
     * @param \App\Models\DomainDealing $domainDealing
     * @return \App\Models\DomainDealing
     */
    public function save(
        \App\Models\DomainDealing $domainDealing
    ): \App\Models\DomainDealing {
        $domainDealing->save();

        return $domainDealing;
    }

    /**
     * @param array $attributes
     * @return \App\Models\DomainDealing
     */
    public function store(array $attributes): \App\Models\DomainDealing
    {
        $domainDealing = DomainDealing::create($attributes);

        return $domainDealing;
    }

    /**
     * @param \App\Models\DomainDealing $domainDealing
     * @return void
     */
    public function delete(\App\Models\DomainDealing $domainDealing): void
    {
        $domainDealing->delete();
    }
}
