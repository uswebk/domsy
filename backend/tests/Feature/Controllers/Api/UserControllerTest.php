<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Infrastructures\Models\Company;
use App\Infrastructures\Models\User;
use App\Services\Application\Api\User\FetchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = Mockery::mock(FetchService::class);

        // NOTE: For individuals, it would be 403 error.
        $this->company = Company::factory(['id' => 2])->create();
        $users = User::factory(['company_id' => $this->company->id])->count(10)->create();

        $this->mock->shouldReceive('getResponse')
            ->andReturn(UserResource::collection($users));

        $this->instance(FetchService::class, $this->mock);
    }

    /** @test */
    public function it_fetch(): void
    {
        $user = User::factory(['company_id' => $this->company->id])->create();
        $response = $this->actingAs($user)
            ->get('/api/user/');

        $response->assertOk()
            ->assertJsonCount(10);
    }
}
