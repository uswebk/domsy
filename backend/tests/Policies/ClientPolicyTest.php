<?php

namespace Tests\Unit\Policies;

use App\Constants\CompanyConstant;
use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\DnsRecordType;
use App\Infrastructures\Models\User;
use App\Policies\ClientPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ClientPolicyTest extends TestCase
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
    public function it_is_owner_then_user_belong_to_company()
    {
        $user = User::factory()->create();
        $client = Client::factory(['user_id' => $user->id])->create();

        $clientPolicy = new ClientPolicy();

        $this->assertTrue($clientPolicy->owner($user, $client));
    }

    /**
     * @test
     */
    public function it_is_not_owner_then_user_belong_to_company()
    {
        $user = User::factory()->create();
        $userOfClientOwner = User::factory()->create();
        $client = Client::factory(['user_id' => $userOfClientOwner->id])->create();

        $clientPolicy = new ClientPolicy();

        $this->assertFalse($clientPolicy->owner($user, $client));
    }

    /**
     * @test
     */
    public function it_is_owner_then_user_not_belong_to_company()
    {
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();
        $client = Client::factory(['user_id' => $user->id])->create();

        $clientPolicy = new ClientPolicy();

        $this->assertTrue($clientPolicy->owner($user, $client));
    }

    /**
     * @test
     */
    public function it_is_not_owner_then_user_not_belong_to_company()
    {
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();
        $userOfClientOwner = User::factory()->create();
        $client = Client::factory(['user_id' => $userOfClientOwner->id])->create();

        $clientPolicy = new ClientPolicy();

        $this->assertFalse($clientPolicy->owner($user, $client));
    }
}
