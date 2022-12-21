<?php

declare(strict_types=1);

namespace App\Repositories\Company;

interface CompanyRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\Company
     */
    public function store(array $attributes): \App\Models\Company;
}
