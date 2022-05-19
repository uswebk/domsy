<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Client;

use App\Infrastructures\Models\Eloquent\Client;

final class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\Client $client
     * @return \App\Infrastructures\Models\Eloquent\Client
     */
    public function save(
        \App\Infrastructures\Models\Eloquent\Client $client
    ): \App\Infrastructures\Models\Eloquent\Client {
        $client->save();

        return $client;
    }

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Eloquent\Client
     */
    public function store(array $attributes): \App\Infrastructures\Models\Eloquent\Client
    {
        $client = Client::create($attributes);

        return $client;
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Client $client
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Eloquent\Client $client): void
    {
        $client->delete();
    }
}
