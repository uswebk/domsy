<?php

declare(strict_types=1);

namespace App\Repositories\Domain\Dealing;

use App\Models\DomainDealing;

final class EloquentDealingRepository implements DealingRepositoryInterface
{
    /**
     * @param DomainDealing $domainDealing
     * @return DomainDealing
     */
    public function save(DomainDealing $domainDealing): DomainDealing
    {
        $domainDealing->save();

        return $domainDealing;
    }

    /**
     * @param array $attributes
     * @return DomainDealing
     */
    public function store(array $attributes): DomainDealing
    {
        $domainDealing = DomainDealing::create($attributes);

        return $domainDealing;
    }

    /**
     * @param DomainDealing $domainDealing
     * @return void
     */
    public function delete(DomainDealing $domainDealing): void
    {
        $domainDealing->delete();
    }
}
