<?php

declare(strict_types=1);

namespace Tests\Unit\Repository\Client;

use App\Models\Client;
use App\Models\User;
use App\Repositories\Client\EloquentClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentClientRepositoryTest extends TestCase
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
            'email' => 'test',
            'zip' => '1111111',
            'address' => 'test',
            'phone_number' => '1111111111',
        ];

        $this->assertDatabaseMissing('clients', [
            'user_id' => $user->id,
            'name' => 'test',
        ]);

        $clientRepository = new EloquentClientRepository();
        $client = $clientRepository->store($data);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * @test
     */
    public function it_save()
    {
        $client = Client::factory()->create();
        $client->name = 'test';

        $clientRepository = new EloquentClientRepository();
        $clientResult = $clientRepository->save($client);

        $this->assertSame($clientResult->name, 'test');
    }

    /**
     * @test
     */
    public function it_delete()
    {
        $id = 1;
        $client = Client::factory(['id' => $id])->create();

        $this->assertDatabaseHas('clients', [
            'id' => $id,
        ]);

        $clientRepository = new EloquentClientRepository();
        $clientRepository->delete($client);

        $this->assertDatabaseMissing('clients', [
            'id' => $id,
        ]);
    }
}
