<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Subdomain;

use App\Infrastructures\Models\Eloquent\Subdomain;

final class SubdomainRepository implements SubdomainRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function save(
        \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
    ): \App\Infrastructures\Models\Eloquent\Subdomain {
        $subdomain->save();

        return $subdomain;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\Subdomain
    {
        $domain = Subdomain::create($attributes);

        return $domain;
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Eloquent\Subdomain $subdomain): void
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
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function updateOfTtlPriority(
        int $domainId,
        int $typeId,
        string $prefix,
        string $value,
        int $ttl,
        int $priority
    ): \App\Infrastructures\Models\Eloquent\Subdomain {
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
