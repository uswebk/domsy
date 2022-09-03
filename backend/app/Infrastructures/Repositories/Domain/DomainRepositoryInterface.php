<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

interface DomainRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @return \App\Infrastructures\Models\Domain
     */
    public function save(\App\Infrastructures\Models\Domain $domain): \App\Infrastructures\Models\Domain;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Domain
     */
    public function store(array $attributes): \App\Infrastructures\Models\Domain;

    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Domain $domain): void;
}
