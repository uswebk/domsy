<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Subdomain;

use App\Infrastructures\Models\Eloquent\Subdomain;

interface SubdomainRepositoryInterface
{
    /**
     * @param Subdomain $subdomain
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function save(Subdomain $subdomain): \App\Infrastructures\Models\Eloquent\Subdomain;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\Subdomain;

    /**
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Eloquent\Subdomain $subdomain): void;

    /**
     * @param integer $domainId
     * @param integer $typeId
     * @param string $prefix
     * @param string $value
     * @param integer $ttl
     * @param integer $priority
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function updateOfTtlPriority(
        int $domainId,
        int $typeId,
        string $prefix,
        string $value,
        int $ttl,
        int $priority
    ): \App\Infrastructures\Models\Eloquent\Subdomain;
}
