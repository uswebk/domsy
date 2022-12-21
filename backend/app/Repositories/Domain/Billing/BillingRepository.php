<?php

declare(strict_types=1);

namespace App\Repositories\Domain\Billing;

use App\Models\DomainBilling;

final class BillingRepository implements BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\DomainBilling
     */
    public function store(array $attributes): \App\Models\DomainBilling
    {
        $domainBilling = DomainBilling::create($attributes);

        return $domainBilling;
    }

    /**
     * @param \App\Models\DomainBilling $domainBilling
     * @return \App\Models\DomainBilling
     */
    public function save(
        \App\Models\DomainBilling $domainBilling
    ): \App\Models\DomainBilling {
        $domainBilling->save();

        return $domainBilling;
    }

    /**
     * @param array $attributes
     * @return \App\Models\DomainBilling
     */
    public function firstOrCreate(array $attributes): \App\Models\DomainBilling
    {
        return DomainBilling::firstOrCreate($attributes);
    }

    /**
     * @param \App\Models\DomainBilling $domainBilling
     * @param boolean $isFixed
     * @return void
     */
    public function updateIsFixed(
        \App\Models\DomainBilling $domainBilling,
        bool $isFixed
    ) {
        $hoge = $domainBilling->id;
        $domainBilling->is_fixed = $isFixed;
        $domainBilling->save();

        return $domainBilling;
    }
}
