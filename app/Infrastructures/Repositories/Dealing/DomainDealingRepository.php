<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Dealing;

use App\Infrastructures\Models\Eloquent\DomainDealing;

final class DomainDealingRepository implements DomainDealingRepositoryInterface
{
    public function save(DomainDealing $domainDealing): DomainDealing
    {
        $domainDealing->save();

        return $domainDealing;
    }

    public function store(array $attributes): DomainDealing
    {
        $domainDealing = DomainDealing::create($attributes);

        return $domainDealing;
    }

    public function delete(DomainDealing $domainDealing): void
    {
        $domainDealing->delete();
    }
}
