<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Subdomain;

use App\Infrastructures\Models\Subdomain;

interface SubdomainRepositoryInterface
{
    /**
     * @param Subdomain $subdomain
     * @return \App\Infrastructures\Models\Subdomain
     */
    public function save(Subdomain $subdomain): \App\Infrastructures\Models\Subdomain;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Subdomain
     */
    public function store(array $attributes): \App\Infrastructures\Models\Subdomain;

    /**
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Subdomain $subdomain): void;

    /**
     * @param integer $domainId
     * @param integer $typeId
     * @param string $prefix
     * @param string $value
     * @param integer $ttl
     * @param integer $priority
     * @return \App\Infrastructures\Models\Subdomain
     */
    public function updateOfTtlPriority(
        int $domainId,
        int $typeId,
        string $prefix,
        string $value,
        int $ttl,
        int $priority
    ): \App\Infrastructures\Models\Subdomain;
}
