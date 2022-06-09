<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Billing;

use App\Infrastructures\Models\Eloquent\DomainBilling;

final class BillingRepository implements BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\DomainBilling
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\DomainBilling
    {
        $domainBilling = DomainBilling::create($attributes);

        return $domainBilling;
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainBilling $domainBilling
     * @param boolean $isFixed
     * @return void
     */
    public function updateIsFixed(
        \App\Infrastructures\Models\Eloquent\DomainBilling $domainBilling,
        bool $isFixed
    ) {
        $domainBilling->is_fixed = $isFixed;
        $domainBilling->save();

        return $domainBilling;
    }
}
