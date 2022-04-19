<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Client;

use App\Infrastructures\Models\Eloquent\Client;

final class ClientRepository implements ClientRepositoryInterface
{
    public function save(Client $client): client
    {
        $client->save();

        return $client;
    }

    public function store(array $attributes): Client
    {
        $client = Client::create($attributes);

        return $client;
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}
