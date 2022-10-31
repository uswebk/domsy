<?php

namespace Tests\Unit\Rules;

use App\Constants\CompanyConstant;
use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\User;
use App\Rules\ClientOwner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientOwnerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('CompanySeeder');
    }

    /**
     * @test
     */
    public function it_passes_then_user_belong_to_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::factory(['user_id' => $user->id])->create();
        $clientOwner = new ClientOwner();

        $this->assertTrue($clientOwner->passes($user, $client->id));
    }

    /**
     * @test
     */
    public function it_passes_then_user_not_belong_to_company()
    {
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();
        $this->actingAs($user);

        $client = Client::factory(['user_id' => $user->id])->create();
        $clientOwner = new ClientOwner();

        $this->assertTrue($clientOwner->passes($user, $client->id));
    }

    /**
     * @test
     */
    public function it_not_passes_then_user_belong_to_company()
    {
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();
        $userOfClientOwner = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory(['user_id' => $userOfClientOwner->id])->create();
        $clientOwner = new ClientOwner();

        $this->assertFalse($clientOwner->passes($user, $client->id));
    }

    /**
     * @test
     */
    public function it_not_passes_then_user_not_belong_to_company()
    {
        $user = User::factory()->create();
        $userOfClientOwner = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory(['user_id' => $userOfClientOwner->id])->create();
        $clientOwner = new ClientOwner();

        $this->assertFalse($clientOwner->passes($user, $client->id));
    }

    /**
     * @test
     */
    public function it_message()
    {
        $clientOwner = new ClientOwner();
        $this->assertSame($clientOwner->message(), 'Client does not exist');
    }
}
