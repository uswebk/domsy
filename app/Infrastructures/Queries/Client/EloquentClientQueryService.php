<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Client;

use App\Infrastructures\Models\Eloquent\Client;

final class EloquentClientQueryService
{
    public function findById(int $id): Client
    {
        return Client::findOrFail($id);
    }
}
