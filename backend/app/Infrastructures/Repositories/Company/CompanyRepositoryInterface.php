<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Company;

interface CompanyRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Company
     */
    public function store(array $attributes): \App\Infrastructures\Models\Company;
}
