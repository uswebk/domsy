<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

interface DomainRepositoryInterface
{
    public function save(\App\Infrastructures\Models\Eloquent\Domain $domain): \App\Infrastructures\Models\Eloquent\Domain;

    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\Domain;

    public function delete(\App\Infrastructures\Models\Eloquent\Domain $domain): void;
}
