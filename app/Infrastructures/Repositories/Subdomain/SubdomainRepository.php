<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Subdomain;

use App\Infrastructures\Models\Subdomain;

final class SubdomainRepository implements SubdomainRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return \App\Infrastructures\Models\Subdomain
     */
    public function save(
        \App\Infrastructures\Models\Subdomain $subdomain
    ): \App\Infrastructures\Models\Subdomain {
        $subdomain->save();

        return $subdomain;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Subdomain
     */
    public function store(array $attributes): \App\Infrastructures\Models\Subdomain
    {
        $domain = Subdomain::create($attributes);

        return $domain;
    }

    /**
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Subdomain $subdomain): void
    {
        $subdomain->delete();
    }

    /**
     * @param integer $domainId
     * @param string $prefix
     * @param integer $typeId
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
    ): \App\Infrastructures\Models\Subdomain {
        $subdomain = Subdomain::firstOrNew([
            'domain_id' => $domainId,
            'type_id' => $typeId,
            'prefix' => $prefix,
            'value' => $value,
        ]);

        $subdomain->ttl = $ttl;
        $subdomain->priority = $priority;

        $subdomain->save();

        return $subdomain;
    }
}
