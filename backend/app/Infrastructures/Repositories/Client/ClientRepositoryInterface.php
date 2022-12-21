<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Client;

interface ClientRepositoryInterface
{
    /**
     * @param \App\Models\Client $client
     * @return \App\Models\Client
     */
    public function save(\App\Models\Client $client): \App\Models\Client;

    /**
     * @param array $attributes
     * @return \App\Models\Client
     */
    public function store(array $attributes): \App\Models\Client;

    /**
     * @param \App\Models\Client $client
     * @return void
     */
    public function delete(\App\Models\Client $client): void;
}
