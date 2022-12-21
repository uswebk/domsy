<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Application\Api\Client;

use App\Constants\CompanyConstant;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use App\Queries\Client\EloquentClientQueryService;
use App\Services\Application\Api\Client\FetchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class FetchServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('CompanySeeder');
    }

    /** @test */
    public function it_get_response_then_individual(): void
    {
        $count = 3;
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();
        Client::factory(['user_id' => $user->id])->count($count)->create();

        $this->actingAs($user);

        $fetchService = new FetchService(new EloquentClientQueryService());
        $result = $fetchService->getResponse();

        $this->assertInstanceOf('\Illuminate\Http\Resources\Json\AnonymousResourceCollection', $result);
        $this->assertCount($count, $result);
    }

    /** @test */
    public function it_get_response_then_company(): void
    {
        $count = 3;
        $company = Company::factory(['id' => 2])->create();
        $user = User::factory(['company_id' => $company->id])->create();
        $user2 = User::factory(['company_id' => $company->id])->create();
        Client::factory(['user_id' => $user->id])->count($count)->create();
        Client::factory(['user_id' => $user2->id])->count($count)->create();

        $this->actingAs($user2);

        $fetchService = new FetchService(new EloquentClientQueryService());
        $result = $fetchService->getResponse();

        $this->assertInstanceOf('\Illuminate\Http\Resources\Json\AnonymousResourceCollection', $result);
        $this->assertCount(6, $result);
    }
}
