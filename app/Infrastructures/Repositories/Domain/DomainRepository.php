<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

use App\Infrastructures\Models\Domain;

final class DomainRepository implements DomainRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @return \App\Infrastructures\Models\Domain
     */
    public function save(
        \App\Infrastructures\Models\Domain $domain
    ): \App\Infrastructures\Models\Domain {
        $domain->save();

        return $domain;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Domain
     */
    public function store(array $attributes): \App\Infrastructures\Models\Domain
    {
        $domain = new Domain();

        $domain->fill($attributes)->save();

        return $domain;
    }

    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Domain $domain): void
    {
        $domain->delete();
    }
}
