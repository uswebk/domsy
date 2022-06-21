<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Billing;

use App\Infrastructures\Models\DomainBilling;

final class BillingRepository implements BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\DomainBilling
     */
    public function store(array $attributes): \App\Infrastructures\Models\DomainBilling
    {
        $domainBilling = DomainBilling::create($attributes);

        return $domainBilling;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\DomainBilling
     */
    public function firstOrCreate(array $attributes): \App\Infrastructures\Models\DomainBilling
    {
        return DomainBilling::firstOrCreate($attributes);
    }

    /**
     * @param \App\Infrastructures\Models\DomainBilling $domainBilling
     * @param boolean $isFixed
     * @return void
     */
    public function updateIsFixed(
        \App\Infrastructures\Models\DomainBilling $domainBilling,
        bool $isFixed
    ) {
        $hoge = $domainBilling->id;
        $domainBilling->is_fixed = $isFixed;
        $domainBilling->save();

        return $domainBilling;
    }
}
