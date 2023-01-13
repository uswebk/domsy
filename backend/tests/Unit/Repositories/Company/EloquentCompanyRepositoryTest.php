<?php

declare(strict_types=1);

namespace Tests\Unit\Repository\Company;

use App\Models\Company;
use App\Repositories\Company\EloquentCompanyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentCompanyRepositoryTest extends TestCase
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

        $companyRepository = new EloquentCompanyRepository();
        $company = $companyRepository->store($data);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertDatabaseHas('companies', $data);
    }
}
