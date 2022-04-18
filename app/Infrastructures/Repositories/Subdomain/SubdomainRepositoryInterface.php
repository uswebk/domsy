<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Subdomain;

use App\Infrastructures\Models\Eloquent\Subdomain;

interface SubdomainRepositoryInterface
{
    public function store(array $attributes): Subdomain;

    public function save(Subdomain $subdomain): Subdomain;

    public function delete(Subdomain $subdomain): void;
}
