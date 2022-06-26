<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Company;

use App\Infrastructures\Models\Company;

final class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Company
     */
    public function store(array $attributes): \App\Infrastructures\Models\Company
    {
        $company = Company::create($attributes);

        return $company;
    }
}
