<?php

declare(strict_types=1);

namespace App\Repositories\Domain;

use App\Models\Domain;

final class EloquentDomainRepository implements DomainRepositoryInterface
{
    /**
     * @param Domain $domain
     * @return Domain
     */
    public function save(Domain $domain): Domain
    {
        $domain->save();

        return $domain;
    }

    /**
     * @param array $attributes
     * @return Domain
     */
    public function store(array $attributes): Domain
    {
        $domain = new Domain();

        $domain->fill($attributes)->save();

        return $domain;
    }

    /**
     * @param Domain $domain
     * @return void
     */
    public function delete(Domain $domain): void
    {
        $domain->delete();
    }
}
