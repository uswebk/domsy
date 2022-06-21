<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Client;

use App\Infrastructures\Models\Client;

final class EloquentClientQueryService implements EloquentClientQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Client
     */
    public function findById(int $id): \App\Infrastructures\Models\Client
    {
        return Client::findOrFail($id);
    }
}
