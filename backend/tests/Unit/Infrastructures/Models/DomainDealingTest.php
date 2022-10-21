<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\DomainBilling;
use App\Infrastructures\Models\DomainDealing;
use App\Infrastructures\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DomainDealingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_domain()
    {
        $domainDealing = DomainDealing::factory([
            'domain_id' => Domain::factory(),
        ])->create();

        $this->assertTrue($domainDealing->domain()->exists());
    }

    /** @test */
    public function it_has_client()
    {
        $domainDealing = DomainDealing::factory([
            'client_id' => Client::factory(),
        ])->create();

        $this->assertTrue($domainDealing->client()->exists());
    }

    /** @test */
    public function it_has_many_billing()
    {
        $domainDealing = DomainDealing::factory()
            ->has(DomainBilling::factory()->count(3))->create();

        $this->assertTrue($domainDealing->domainBillings()->exists());
    }

    /** @test */
    public function it_is_unclaimed()
    {
        $now = now();
        $domainDealing = DomainDealing::factory([
            'billing_date' => $now->copy()->addDay()->toDateString(),
        ])->create();

        $this->assertTrue($domainDealing->isUnclaimed());
    }

    /** @test */
    public function it_is_not_unclaimed()
    {
        $now = now();
        $domainDealing = DomainDealing::factory([
            'billing_date' => $now->copy()->subDay()->toDateString(),
        ])->create();

        $this->assertFalse($domainDealing->isUnclaimed());
    }

    /** @test */
    public function it_get_user_id()
    {
        $user = User::factory()->create();
        $domain = Domain::factory(['user_id' => $user->id])->create();
        $domainDealing = DomainDealing::factory(['domain_id' => $domain->id])->create();

        $this->assertSame($domainDealing->getUserId(), $user->id);
    }

    /** @test */
    public function it_get_billing_amount()
    {
        $subtotal = 1000;
        $discount = 100;
        $assertAmount = $subtotal - $discount;

        $domainDealing = DomainDealing::factory([
            'subtotal' => $subtotal,
            'discount' => $discount,
        ])->create();

        $this->assertSame($domainDealing->getBillingAmount(), $assertAmount);
    }

    /** @test */
    public function it_get_next_billing()
    {
        $domainDealing = DomainDealing::factory()->create();

        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_fixed' => true,
        ])->create();

        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_auto' => false,
        ])->create();

        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'billing_date' => now()->addDay()->toDateString(),
            'is_fixed' => false,
            'is_auto' => true,
        ])->create();

        $recentDateBilling = DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'billing_date' => now()->toDateString(),
            'is_fixed' => false,
            'is_auto' => true,
        ])->create();

        $assertBilling = $domainDealing->getNextBilling();

        $this->assertEquals($recentDateBilling->id, $assertBilling->id);
    }

    /** @test */
    public function it_get_total_price()
    {
        $domainDealing = DomainDealing::factory()->create();

        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_fixed' => true,
            'total' => 100
        ])->create();

        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_fixed' => false,
            'total' => 100,
        ])->create();

        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_fixed' => true,
            'total' => 100,
        ])->create();

        $this->assertSame($domainDealing->getTotalPrice(), 200);
    }

    /** @test */
    public function it_get_domain_name()
    {

        $domainName = 'domsy.com';
        $domain = Domain::factory(['name' => $domainName])->create();
        $domainDealing = DomainDealing::factory(['domain_id' => $domain->id])->create();

        $this->assertSame($domainDealing->getDomainName(), $domainName);
    }

    /** @test */
    public function it_has_fixed_billing()
    {

        $domainDealing = DomainDealing::factory()->create();
        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_fixed' => true,
        ])->create();

        $this->assertTrue($domainDealing->hasFixedBilling());
    }

    /** @test */
    public function it_do_not_have_fixed_billing()
    {

        $domainDealing = DomainDealing::factory()->create();
        DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
            'is_fixed' => false,
        ])->create();

        $this->assertFalse($domainDealing->hasFixedBilling());
    }
}
