<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\Client;

use App\Infrastructures\Models\Eloquent\Client;

interface ClientRepositoryInterface
{
    public function save(Client $client): Client;

    public function store(array $attributes): Client;

    public function delete(Client $client): void;
}
