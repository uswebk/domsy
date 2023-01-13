<?php

declare(strict_types=1);

namespace App\Repositories\Company;

use App\Models\Company;

final class EloquentCompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Company
     */
    public function store(array $attributes): Company
    {
        return Company::create($attributes);
    }
}
