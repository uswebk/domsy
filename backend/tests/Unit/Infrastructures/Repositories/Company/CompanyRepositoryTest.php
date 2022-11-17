<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Repository\Company;

use App\Infrastructures\Models\Company;
use App\Infrastructures\Repositories\Company\CompanyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CompanyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_store()
    {
        $companyId = 100;
        $data = [
            'name' => 'test',
            'email' => 'test@example.com',
            'zip' => 1000000,
            'address' => 'City',
            'phone_number' => 0000000000,
        ];

        $this->assertDatabaseMissing('companies', [
            'id' => $companyId,
        ]);

        $companyRepository = new CompanyRepository();
        $company = $companyRepository->store($data);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertDatabaseHas('companies', $data);
    }
}
