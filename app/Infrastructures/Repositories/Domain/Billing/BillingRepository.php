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
}
