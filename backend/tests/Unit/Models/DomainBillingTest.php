<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Domain;
use App\Models\DomainBilling;
use App\Models\DomainDealing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DomainBillingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_domain_dealing()
    {
        $domainDealing = DomainDealing::factory()->create();
        $domainBilling = DomainBilling::factory([
            'dealing_id' => $domainDealing->id,
        ])->create();

        $this->assertTrue($domainBilling->domainDealing()->exists());
    }

    /** @test */
    public function it_get_user_id()
    {
        $userId = User::factory()->create()->id;
        $domainId = Domain::factory([
            'user_id' => $userId,
        ])->create()->id;
        $dealingId = DomainDealing::factory([
            'domain_id' => $domainId,
        ])->create()->id;
        $domainBilling = DomainBilling::factory([
            'dealing_id' => $dealingId,
        ])->create();

        $this->assertSame($domainBilling->getUserId(), $userId);
    }

    /** @test */
    public function it_get_domain_name()
    {
        $domainName = 'test.com';
        $domainId = Domain::factory([
            'name' => $domainName,
        ])->create()->id;
        $dealingId = DomainDealing::factory([
            'domain_id' => $domainId,
        ])->create()->id;
        $domainBilling = DomainBilling::factory([
            'dealing_id' => $dealingId,
        ])->create();

        $this->assertSame($domainBilling->getDomainName(), $domainName);
    }

    /** @test */
    public function it_when_is_fixed()
    {
        $domainBilling = DomainBilling::factory([
            'is_fixed' => true,
        ])->create();

        $this->assertTrue($domainBilling->isFixed());
    }

    /** @test */
    public function it_when_is_not_fixed()
    {
        $domainBilling = DomainBilling::factory([
            'is_fixed' => false,
        ])->create();

        $this->assertFalse($domainBilling->isFixed());
    }
}
