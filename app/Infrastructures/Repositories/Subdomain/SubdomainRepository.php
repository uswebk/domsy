<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Subdomain;

use App\Infrastructures\Models\Eloquent\Subdomain;

final class SubdomainRepository implements SubdomainRepositoryInterface
{
    public function store(array $attributes): Subdomain
    {
        $domain = Subdomain::create($attributes);

        return $domain;
    }

    public function save(Subdomain $subdomain): Subdomain
    {
        $subdomain->save();

        return $subdomain;
    }

    public function delete(Subdomain $subdomain): void
    {
        $subdomain->delete();
    }
}
