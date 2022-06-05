<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Billing;

interface BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\DomainBilling
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\DomainBilling;
}
