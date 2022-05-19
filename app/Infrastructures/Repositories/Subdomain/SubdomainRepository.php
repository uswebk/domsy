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
}
