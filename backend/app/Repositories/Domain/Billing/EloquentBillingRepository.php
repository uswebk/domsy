<?php

declare(strict_types=1);

namespace App\Repositories\Domain\Billing;

use App\Models\DomainBilling;

final class EloquentBillingRepository implements BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return DomainBilling
     */
    public function store(array $attributes): DomainBilling
    {
        $domainBilling = DomainBilling::create($attributes);

        return $domainBilling;
    }

    /**
     * @param DomainBilling $domainBilling
     * @return DomainBilling
     */
    public function save(DomainBilling $domainBilling): DomainBilling
    {
        $domainBilling->save();

        return $domainBilling;
    }

    /**
     * @param array $attributes
     * @return DomainBilling
     */
    public function firstOrCreate(array $attributes): DomainBilling
    {
        return DomainBilling::firstOrCreate($attributes);
    }

    /**
     * @param DomainBilling $domainBilling
     * @param boolean $isFixed
     * @return DomainBilling
     */
    public function updateIsFixed(DomainBilling $domainBilling, bool $isFixed): DomainBilling
    {
        $domainBilling->is_fixed = $isFixed;
        $domainBilling->save();

        return $domainBilling;
    }
}
