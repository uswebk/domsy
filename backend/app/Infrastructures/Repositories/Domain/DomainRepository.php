<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

use App\Models\Domain;

final class DomainRepository implements DomainRepositoryInterface
{
    /**
     * @param \App\Models\Domain $domain
     * @return \App\Models\Domain
     */
    public function save(
        \App\Models\Domain $domain
    ): \App\Models\Domain {
        $domain->save();

        return $domain;
    }

    /**
     * @param array $attributes
     * @return \App\Models\Domain
     */
    public function store(array $attributes): \App\Models\Domain
    {
        $domain = new Domain();

        $domain->fill($attributes)->save();

        return $domain;
    }

    /**
     * @param \App\Models\Domain $domain
     * @return void
     */
    public function delete(\App\Models\Domain $domain): void
    {
        $domain->delete();
    }
}
