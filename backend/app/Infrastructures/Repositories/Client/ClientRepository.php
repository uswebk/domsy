<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Client;

use App\Infrastructures\Models\Client;

final class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Client $client
     * @return \App\Infrastructures\Models\Client
     */
    public function save(
        \App\Infrastructures\Models\Client $client
    ): \App\Infrastructures\Models\Client {
        $client->save();

        return $client;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Client
     */
    public function store(array $attributes): \App\Infrastructures\Models\Client
    {
        $client = Client::create($attributes);

        return $client;
    }

    /**
     * @param \App\Infrastructures\Models\Client $client
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Client $client): void
    {
        $client->delete();
    }
}
