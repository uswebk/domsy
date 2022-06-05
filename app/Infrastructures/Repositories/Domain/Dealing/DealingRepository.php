<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Dealing;

use App\Infrastructures\Models\Eloquent\DomainDealing;

final class DealingRepository implements DealingRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function save(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): \App\Infrastructures\Models\Eloquent\DomainDealing {
        $domainDealing->save();

        return $domainDealing;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\DomainDealing
    {
        $domainDealing = DomainDealing::create($attributes);

        return $domainDealing;
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing): void
    {
        $domainDealing->delete();
    }
}
