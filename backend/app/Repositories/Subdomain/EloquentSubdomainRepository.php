<?php

declare(strict_types=1);

namespace App\Repositories\Subdomain;

use App\Models\Subdomain;

final class EloquentSubdomainRepository implements SubdomainRepositoryInterface
{
    /**
     * @param Subdomain $subdomain
     * @return Subdomain
     */
    public function save(Subdomain $subdomain): Subdomain
    {
        $subdomain->save();

        return $subdomain;
    }

    /**
     * @param array $attributes
     * @return Subdomain
     */
    public function store(array $attributes): Subdomain
    {
        $domain = Subdomain::create($attributes);

        return $domain;
    }

    /**
     * @param Subdomain $subdomain
     * @return void
     */
    public function delete(Subdomain $subdomain): void
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
     * @return Subdomain
     */
    public function updateOfTtlPriority(
        int $domainId,
        int $typeId,
        string $prefix,
        string $value,
        int $ttl,
        int $priority
    ): Subdomain {
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
