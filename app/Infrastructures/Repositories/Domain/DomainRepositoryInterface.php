<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Domain;

use App\Infrastructures\Models\Eloquent\Domain;

interface DomainRepositoryInterface
{
    public function save(Domain $domain): Domain;

    public function store(array $attributes): Domain;

    public function delete(Domain $domain): void;
}
