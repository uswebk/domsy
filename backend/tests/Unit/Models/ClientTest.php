<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Client;
use App\Models\DomainDealing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_user(): void
    {
        $client = Client::factory()->create();

        $this->assertTrue($client->user()->exists());
    }

    /** @test */
    public function it_has_many_domain_dealings(): void
    {
        $client = Client::factory()->create();
        DomainDealing::factory([
            'client_id' => $client->id,
        ])->create();

        $this->assertTrue($client->domainDealings()->exists());
    }
}
