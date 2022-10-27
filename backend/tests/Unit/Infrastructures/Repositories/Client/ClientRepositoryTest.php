<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Repository\Client;

use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\User;
use App\Infrastructures\Repositories\Client\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class ClientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_store()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'name' => 'test',
            'name_kana' => 'test',
            'email' => 'test',
            'zip' => '1111111',
            'address' => 'test',
            'phone_number' => '1111111111',
            'updated_at' => now(),
            'created_at' => now(),
        ];

        $clientRepository = new ClientRepository();
        $client = $clientRepository->store($data);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', [
            'user_id' => $user->id,
            'name' => 'test',
        ]);
    }
}
