<?php

declare(strict_types=1);

namespace App\Repositories\Subdomain;

use App\Models\Subdomain;

interface SubdomainRepositoryInterface
{
    /**
     * @param Subdomain $subdomain
     * @return \App\Models\Subdomain
     */
    public function save(Subdomain $subdomain): \App\Models\Subdomain;

    /**
     * @param array $attributes
     * @return \App\Models\Subdomain
     */
    public function store(array $attributes): \App\Models\Subdomain;

    /**
     * @param \App\Models\Subdomain $subdomain
     * @return void
     */
    public function delete(\App\Models\Subdomain $subdomain): void;

    /**
     * @param integer $domainId
     * @param integer $typeId
     * @param string $prefix
     * @param string $value
     * @param integer $ttl
     * @param integer $priority
     * @return \App\Models\Subdomain
     */
    public function updateOfTtlPriority(
        int $domainId,
        int $typeId,
        string $prefix,
        string $value,
        int $ttl,
        int $priority
    ): \App\Models\Subdomain;
}
