<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_users(): void
    {
        $company = Company::factory()->create();
        User::factory([
            'company_id' => $company->id,
        ])->create();

        $this->assertTrue($company->users()->exists());
    }
}
