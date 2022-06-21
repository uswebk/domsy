<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Client;

interface ClientRepositoryInterface
{
    /**
     * @param \App\Infrastructures\Models\Client $client
     * @return \App\Infrastructures\Models\Client
     */
    public function save(\App\Infrastructures\Models\Client $client): \App\Infrastructures\Models\Client;

    /**
     * @param array $attributes
     * @return \App\Infrastructures\Models\Client
     */
    public function store(array $attributes): \App\Infrastructures\Models\Client;

    /**
     * @param \App\Infrastructures\Models\Client $client
     * @return void
     */
    public function delete(\App\Infrastructures\Models\Client $client): void;
}
