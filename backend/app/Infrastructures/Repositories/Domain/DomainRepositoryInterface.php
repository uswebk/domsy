<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

interface DomainRepositoryInterface
{
    /**
     * @param \App\Models\Domain $domain
     * @return \App\Models\Domain
     */
    public function save(\App\Models\Domain $domain): \App\Models\Domain;

    /**
     * @param array $attributes
     * @return \App\Models\Domain
     */
    public function store(array $attributes): \App\Models\Domain;

    /**
     * @param \App\Models\Domain $domain
     * @return void
     */
    public function delete(\App\Models\Domain $domain): void;
}
