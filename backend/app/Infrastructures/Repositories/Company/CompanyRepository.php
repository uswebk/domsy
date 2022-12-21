<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Company;

use App\Models\Company;

final class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Models\Company
     */
    public function store(array $attributes): \App\Models\Company
    {
        $company = Company::create($attributes);

        return $company;
    }
}
