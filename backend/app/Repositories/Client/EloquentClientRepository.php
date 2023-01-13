<?php

declare(strict_types=1);

namespace App\Repositories\Client;

use App\Models\Client;

final class EloquentClientRepository implements ClientRepositoryInterface
{
    /**
     * @param Client $client
     * @return Client
     */
    public function save(Client $client): Client
    {
        $client->save();

        return $client;
    }

    /**
     * @param array $attributes
     * @return Client
     */
    public function store(array $attributes): Client
    {
        return Client::create($attributes);
    }

    /**
     * @param Client $client
     * @return void
     */
    public function delete(Client $client): void
    {
        $client->delete();
    }
}
