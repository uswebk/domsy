<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain\Billing;

interface BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\DomainBilling
     */
    public function store(array $attributes): \App\Infrastructures\Models\DomainBilling;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\DomainBilling
     */
    public function firstOrCreate(array $attributes): \App\Infrastructures\Models\DomainBilling;

    /**
     * @param \App\Infrastructures\Models\DomainBilling $domainBilling
     * @param boolean $isFixed
     * @return void
     */
    public function updateIsFixed(
        \App\Infrastructures\Models\DomainBilling $domainBilling,
        bool $isFixed
    );
}
