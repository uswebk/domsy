<?php

declare(strict_types=1);

namespace App\Repositories\Domain\Billing;

interface BillingRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\DomainBilling
     */
    public function store(array $attributes): \App\Models\DomainBilling;

    /**
     * @param \App\Models\DomainBilling $domainBilling
     * @return \App\Models\DomainBilling
     */
    public function save(\App\Models\DomainBilling $domainBilling): \App\Models\DomainBilling;

    /**
     * @param array $attributes
     * @return \App\Models\DomainBilling
     */
    public function firstOrCreate(array $attributes): \App\Models\DomainBilling;

    /**
     * @param \App\Models\DomainBilling $domainBilling
     * @param boolean $isFixed
     * @return void
     */
    public function updateIsFixed(
        \App\Models\DomainBilling $domainBilling,
        bool $isFixed
    );
}
