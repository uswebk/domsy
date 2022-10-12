<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\User;

use App\Infrastructures\Models\Company;
use App\Infrastructures\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_many_users(): void
    {
        $company = Company::factory()->create();
        User::factory([
            'company_id' => $company->id
        ])->create();

        $this->assertTrue($company->users()->exists());
    }
}
