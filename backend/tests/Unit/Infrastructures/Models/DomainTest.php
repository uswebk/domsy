<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\User;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\DomainBilling;
use App\Infrastructures\Models\DomainDealing;
use App\Infrastructures\Models\Registrar;
use App\Infrastructures\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DomainTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_user()
    {
        $user = User::factory()->create();
        $domain = Domain::factory([
            'user_id' => $user->id
        ])->create();

        $this->assertTrue($domain->user()->exists());
    }

    /** @test */
    public function has_registrar()
    {
        $registrar = Registrar::factory()->create();
        $domain = Domain::factory([
            'registrar_id' => $registrar->id
        ])->create();

        $this->assertTrue($domain->registrar()->exists());
    }

    /** @test */
    public function has_many_dealings()
    {
        $domain = Domain::factory()->create();
        DomainDealing::factory([
            'domain_id' => $domain->id
        ])->create();

        $this->assertTrue($domain->domainDealings()->exists());
    }

    /** @test */
    public function is_expiration_date_by_target_date()
    {
        $now = now();
        $domain = Domain::factory([
            'expired_at' => $now->toDateTimeString()
        ])->create();

        $this->assertTrue($domain->isExpirationDateByTargetDate($now));
        $this->assertTrue(!$domain->isExpirationDateByTargetDate($now->copy()->addDay()));
    }

    /** @test */
    public function is_not_expiration_date_by_target_date()
    {
        $now = now();
        $domain = Domain::factory([
            'expired_at' => $now->toDateTimeString()
        ])->create();

        $this->assertTrue(!$domain->isExpirationDateByTargetDate($now->copy()->addDay()));
    }

    /** @test */
    public function is_owned()
    {
        $domain = Domain::factory([
            'is_active' => true,
            'is_transferred' => false
        ])->create();

        $this->assertTrue($domain->isOwned());
    }

    /** @test */
    public function is_not_owned()
    {
        $domain = Domain::factory([
            'is_active' => true,
            'is_transferred' => true
        ])->create();

        $this->assertTrue(!$domain->isOwned());
    }

    /** @test */
    public function get_total_seller()
    {
        $count = 10;
        $price = 1000;
        $domain = Domain::factory()->create();

        for ($i = 0; $i < $count; $i++) {
            $domainDealing = DomainDealing::factory([
                'domain_id' => $domain->id
            ])->create();

            DomainBilling::factory([
                'dealing_id' => $domainDealing->id,
                'total' => $price,
            ])->create();
        }

        $this->assertSame($domain->getTotalSeller(), $count * $price);
    }
}
