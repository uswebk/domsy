<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Domain\Client;

use App\Infrastructures\Models\Eloquent\Client;
use App\Infrastructures\Models\Eloquent\User;
use App\Services\Domain\Client\HasService;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class HasServiceTest extends TestCase
{
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();
    }

    /**
    * @test
    */
    public function hasClientCheck(): void
    {
        $user = User::factory()->create();
        $client = Client::factory([
            'user_id' => $user->id,
        ])->create();

        $hasService = new HasService($client->id, $user->id);

        $this->assertTrue($hasService->execute());
    }
}
